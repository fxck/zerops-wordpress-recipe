zerops service import

```yaml
#yamlPreprocessor=on
services:
  - hostname: wp
    type: php-apache@8.1+2.4
    minContainers: 1
    buildFromGit: https://github.com/fxck/zerops-wordpress-recipe
    enableSubdomainAccess: true
    pipelineConfig:
      wp:
        build:
          base:
            - php@8.1
          prepare:
            - curl -sS https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o wp-cli.phar
            - chmod +x wp-cli.phar
            - sudo mv wp-cli.phar /usr/local/bin/wp
          build:
            - composer update
            - wp plugin activate --all --allow-root
          deploy: [ ./ ]
        run:
          documentRoot: ''

    envVariables:
      WORDPRESS_TITLE: zerops wordpress
      WORDPRESS_URL: ${zeropsSubdomain}
      WORDPRESS_DB_HOST: ${db_hostname}
      WORDPRESS_DB_NAME: ${db_hostname}
      WORDPRESS_DB_PASSWORD: ${db_password}
      WORDPRESS_DB_USER: ${db_user}
      WORDPRESS_TABLE_PREFIX: wp_
      WORDPRESS_DEBUG: "true"
      WORDPRESS_DEBUG_DISPLAY: "true"
      WORDPRESS_STORAGE_KEY_ID: ${storage_accessKeyId}
      WORDPRESS_STORAGE_ACCESS_KEY: ${storage_secretAccessKey}
      WORDPRESS_STORAGE_BUCKET: ${projectId}.storage
      WORDPRESS_AUTH_KEY: <@getRandomString(64)}>
      WORDPRESS_AUTH_SALT: <@getRandomString(64)}>
      WORDPRESS_LOGGED_IN_KEY: <@getRandomString(64)}>
      WORDPRESS_LOGGED_IN_SALT: <@getRandomString(64)}>
      WORDPRESS_NONCE_KEY: <@getRandomString(64)}>
      WORDPRESS_NONCE_SALT: <@getRandomString(64)}>
      WORDPRESS_SECURE_AUTH_KEY: <@getRandomString(64)}>
      WORDPRESS_SECURE_AUTH_SALT: <@getRandomString(64)}>
      WORDPRESS_REDIS_USER_SESSION_HOST: redis
```
