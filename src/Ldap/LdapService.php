<?php

namespace CornellCustomDev\LaravelStarterKit\Ldap;

use Exception;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use LDAP\Connection;

class LdapService
{
    public const LDAP_CACHE_SECONDS = 300;

    public function __construct(
        private readonly Ldap $ldap,
        private readonly int $cacheSeconds = self::LDAP_CACHE_SECONDS,
    ) {
    }

    /**
     * Retrieve the instance of LdapService from the service container.
     */
    public static function make(): LdapService
    {
        return app(LdapService::class);
    }

    /**
     * Get a cached result for LdapService::make()->find($netid).
     *
     * @throws InvalidArgumentException
     * @throws LdapDataException
     */
    public static function get(?string $netid, bool $bustCache = false): ?LdapData
    {
        if (empty($netid)) {
            throw new InvalidArgumentException(LdapService::class.'::get requires netid');
        }

        $cacheKey = LdapService::class.'::get_'.$netid;
        if ($bustCache) {
            Cache::forget($cacheKey);
        }

        $ldapService = LdapService::make();

        return Cache::remember($cacheKey, now()->addSeconds($ldapService->cacheSeconds),
            fn () => $ldapService->find($netid));
    }

    /**
     * Find a user in the LDAP directory, returning an LdapData object for the first entry found.
     *
     * @throws LdapDataException
     */
    public function find(string $netid, ?bool $debug = false): ?LdapData
    {
        $connection = $this->makeBindConnection();

        try {
            $response = $this->ldap->getFirst($connection, "uid=$netid");
            if ($debug) {
                dump(json_encode($response));
            }
            if (! $response) {
                return null;
            }
            $data = self::parseResponse($response);
        } catch (Exception $e) {
            // $this->logError("Error in ldap_search for $netid: " . $e->getMessage());
            throw new LdapDataException($e->getMessage());
        }

        // Load the data into an immutable object.
        return LdapData::make($data);
    }

    /**
     * Parse a response from ldap_search into a simple array.
     */
    public static function parseResponse(?array $response = []): array
    {
        unset($response['dn']);
        $data = [];
        foreach ($response as $key => $value) {
            if (is_numeric($key) || $key == 'count') {
                continue;
            }
            if ($value['count'] == 1) {
                $parsedValue = $value[0];
            } else {
                unset($value['count']);
                $parsedValue = $value;
            }
            // Only populate the field if we have data.
            if (! empty($parsedValue)) {
                $data[$key] = $parsedValue;
            }
        }

        return $data;
    }

    /**
     * @throws LdapDataException
     */
    private function makeBindConnection(): bool|Connection
    {
        $connection = $this->ldap->connect();
        if (! $connection) {
            throw new LdapDataException('Could not connect to LDAP server.');
        }

        $result = $this->ldap->bind($connection);
        if (! $result) {
            throw new LdapDataException('Could not bind to LDAP server.');
        }

        $parsed_result = $this->ldap->parseResult($connection, $result);
        if ($parsed_result !== true) {
            throw new LdapDataException("Error response from ldap_bind: $parsed_result");
        }

        return $connection;
    }
}
