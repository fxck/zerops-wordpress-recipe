zerops service import

```yaml
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
            - wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && sudo mv wp-cli.phar /usr/local/bin/wp
          build:
            - wp core install --url="${WORDPRESS_URL}" --title="${WORDPRESS_TITLE}" --admin_user="${WORDPRESS_ADMIN_USER}" --admin_password="${WORDPRESS_ADMIN_PASSWORD}" --admin_email="${WORDPRESS_ADMIN_EMAIL}" --allow-root
          deploy:
            ./
        run:
          documentRoot: 'public'

    envVariables:
      WORDPRESS_TITLE: zerops wordpress
      WORDPRESS_URL: ${zeropsSubdomain}

      WORDPRESS_ADMIN_EMAIL: admin@admin.com
      WORDPRESS_ADMIN_PASSWORD: admin1234
      WORDPRESS_ADMIN_USER: admin

      WORDPRESS_DB_HOST: ${db_hostname}
      WORDPRESS_DB_NAME: ${db_hostname}
      WORDPRESS_DB_PASSWORD: ${db_password}
      WORDPRESS_DB_USER: ${db_user}
      WORDPRESS_TABLE_PREFIX: wp_

      WORDPRESS_DEBUG: "true"

      WORDPRESS_AUTH_KEY: {$getRandomString(20)}
      WORDPRESS_AUTH_SALT: {$getRandomString(20)}
      WORDPRESS_LOGGED_IN_KEY: {$getRandomString(20)}
      WORDPRESS_LOGGED_IN_SALT: {$getRandomString(20)}
      WORDPRESS_NONCE_KEY: {$getRandomString(20)}
      WORDPRESS_NONCE_SALT: {$getRandomString(20)}
      WORDPRESS_SECURE_AUTH_KEY: {$getRandomString(20)}
      WORDPRESS_SECURE_AUTH_SALT: {$getRandomString(20)}
```
