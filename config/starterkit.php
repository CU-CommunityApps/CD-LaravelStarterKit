<?php

return [

    /* 
     * The users' netid will be retrieved from an environment variable
     * populated by the Apache shibboleth module.  
     * The default env variable is REMOTE USER, but this may be e.g,  , 
     * REDIRECT_REMOTE_USER on some servers.
     * 
     * For local development without shibboleth, you can add
     * REMOTE_USER=<netid>
     * to your project .env file to set the user netid. 
     * 
     * In project code, use config('starterkit.netid') to retrieve the netid
     * 
     */
    'netid' => env("REMOTE_USER_VARIABLE", "REMOTE_USER"),

];