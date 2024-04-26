<?php

return [

    /* 
     * The users' netid may be retrieved from an environment variable
     * populated by the Apache shibboleth module.  
     * 
     * The default env variable is REMOTE USER, but this may be e.g, 
     * REDIRECT_REMOTE_USER on some servers, depending on how PHP is installed.
     * 
     * This configuration allows configuration of the remote_user_variable so it
     * is not hardcoded in the application. 
     * 
     * In project code, use env(config('starterkit.remote_user_variable')) to retrieve the netid
     *
     * For local development without shibboleth, you can add
     * REMOTE_USER=<netid>
     * to your project .env file to set the user netid. 
     *
     */
    'remote_user_variable' => env("REMOTE_USER_VARIABLE", "REMOTE_USER"),

];