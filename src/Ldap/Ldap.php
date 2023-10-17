<?php

namespace CornellCustomDev\LaravelStarterKit\Ldap;

use LDAP\Connection;
use LDAP\Result;
use LDAP\ResultEntry;

/**
 * Wrappers for standard LDAP PHP extension functions used from the LdapService class.
 *
 * This class allows us to provide some simplifications and testability for the LdapService class.
 */
class Ldap
{
    public function __construct(
        private readonly string $ldapUser,
        private readonly string $ldapPass,
        private readonly string $ldapServer,
        private readonly string $ldapBaseDn,
    ) {
    }

    /**
     * Search for a user in the LDAP directory, returning the attributes for the first entry.
     */
    public function getFirst($connection, $filter): ?array
    {
        $result = $this->search($connection, $this->ldapBaseDn, $filter);
        if (! $result) {
            return null;
        }

        $result_entry = $this->firstEntry($connection, $result);
        if (! $result_entry) {
            return null;
        }

        return $this->getAttributes($connection, $result_entry);
    }

    public function connect(): bool|Connection
    {
        return ldap_connect($this->ldapServer);
    }

    public function bind($ldap): bool|Result
    {
        return ldap_bind_ext($ldap, "uid=$this->ldapUser", $this->ldapPass);
    }

    public function search($ldap, string $base_dn, string $filter): array|bool|Result
    {
        return ldap_search($ldap, $base_dn, $filter);
    }

    public function firstEntry($ldap, $result): bool|ResultEntry
    {
        return ldap_first_entry($ldap, $result);
    }

    public function getAttributes($ldap, $entry): array
    {
        return ldap_get_attributes($ldap, $entry);
    }

    public function parseResult($ldap, $result): bool|string
    {
        return ldap_parse_result($ldap, $result, $error_code, $matched_dn, $error_message) ?: $error_message;
    }
}
