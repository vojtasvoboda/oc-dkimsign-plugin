# DKIM Sign for OctoberCMS

This plugin adds DKIM signature to all outgoing emails.

## Installation

1) Generate DKIM public and private keys, you can to it for example here: https://tools.socketlabs.com/dkim/generator
   If running application on subdomain, enter subdomain.domain.tld in the domain field, otherwise enter domain.tld.

2) On your domain create TXT DNS entry with public part of the key, for example record with name (domain name):
    `dkim._domainkey.subdomain.domain.tld`

    Where `dkim` is selector used while generating key in step 1.

    Record value is:

    ```
    v=DKIM1; k=rsa; p=<public key>
    ```

    You can check DNS with this tool: https://mxtoolbox.com/supertool3 Type domain name and select DKIM Lookup. Domain should be in format:

    ```
    subdomain.domain.tld:selector
    ```

    For example:

    ```
    example.com:dkim
    ```

3) Copy private key to some file, for example `storage/app/uploads/protected/dkim/private.key`
   !!! This file should not be accessible from the web, so we're going to save it to protected directory !!!

4) Setup plugin by .env file:

    Below you can see all variables with default values:

    ```dotenv
    DKIM_ENABLED=false
    DKIM_PRIVATE_KEY=
    DKIM_DOMAIN=<config.app.url>
    DKIM_SELECTOR=dkim
    DKIM_PASSPHRASE=
    ```

    For my example it is enough to set:

    ```dotenv
    DKIM_ENABLED=true
    DKIM_PRIVATE_KEY=storage/app/uploads/protected/dkim/private.key
    ```

    Domain is by default taken from config app.url. Selector is by default `dkim`. Passphrase is empty by default.

5) Send testing email to Gmail recipient where you find Show original in the mail detail and there you should see: DKIM PASS.

## Contributing

Please send Pull Request to the master branch.

## License

Fakturoid plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as
OctoberCMS platform.
