# Zerops WordPress

## Import whole project

```yaml
#yamlPreprocessor=on
project:
  name: zerops-wordpress
  tags:
    - wordpress
services:
  - hostname: wp
    type: php-apache@8.1+2.4
    minContainers: 1
    buildFromGit: https://github.com/fxck/zerops-wordpress-recipe
    enableSubdomainAccess: true
    envVariables:
      WORDPRESS_TITLE: zerops wordpress
      WORDPRESS_URL: ${zeropsSubdomain}
      WORDPRESS_DB_HOST: ${db_hostname}
      WORDPRESS_DB_NAME: ${db_hostname}
      WORDPRESS_DB_PASSWORD: ${db_password}
      WORDPRESS_DB_USER: ${db_user}
      WORDPRESS_TABLE_PREFIX: wp_
      WORDPRESS_ADMIN_EMAIL: admin@admin.com
      WORDPRESS_ADMIN_PASSWORD: <@generateRandomString(<8>)>
      WORDPRESS_ADMIN_USER: admin
      WORDPRESS_DEBUG: "true"
      WORDPRESS_DEBUG_DISPLAY: "true"
      WORDPRESS_STORAGE_URL: ${storage_apiUrl}
      WORDPRESS_STORAGE_KEY_ID: ${storage_accessKeyId}
      WORDPRESS_STORAGE_ACCESS_KEY: ${storage_secretAccessKey}
      WORDPRESS_STORAGE_BUCKET_NAME: storage
      WORDPRESS_STORAGE_BUCKET: ${storage_serviceId|lower}.${WORDPRESS_STORAGE_BUCKET_NAME}
      WORDPRESS_AUTH_KEY: <@generateRandomString(<64>)>
      WORDPRESS_AUTH_SALT: <@generateRandomString(<64>)>
      WORDPRESS_LOGGED_IN_KEY: <@generateRandomString(<64>)>
      WORDPRESS_LOGGED_IN_SALT: <@generateRandomString(<64>)>
      WORDPRESS_NONCE_KEY: <@generateRandomString(<64>)>
      WORDPRESS_NONCE_SALT: <@generateRandomString(<64>)>
      WORDPRESS_SECURE_AUTH_KEY: <@generateRandomString(<64>)>
      WORDPRESS_SECURE_AUTH_SALT: <@generateRandomString(<64>)>
      WORDPRESS_REDIS_USER_SESSION_HOST: redis

  - hostname: storage
    type: object-storage
    objectStorageSize: 2
    priority: 10

  - hostname: redis
    type: keydb@6
    mode: NON_HA
    priority: 10

  - hostname: db
    type: mariadb@10.4
    mode: HA
    priority: 10
```

## Import another WordPress instance into an existing project

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
            - |
              if ! $(wp core is-installed --allow-root); then
                wp core install --allow-root --url=$WORDPRESS_URL --title="$WORDPRESS_TITLE" --admin_user=$WORDPRESS_ADMIN_USER --admin_password=$WORDPRESS_ADMIN_PASSWORD --admin_email=$WORDPRESS_ADMIN_EMAIL
              fi
            - wp plugin activate --all --allow-root
          deploy: [ ./ ]
        run:
          init:
            - |
              if ! zcli bucket s3 create storage $WORDPRESS_STORAGE_BUCKET --x-amz-acl=public-read; then
                echo "Skipping, bucket already exists."
              fi
          documentRoot: ''
    envVariables:
      WORDPRESS_TITLE: zerops wordpress
      WORDPRESS_URL: ${zeropsSubdomain}
      WORDPRESS_DB_HOST: ${db_hostname}
      WORDPRESS_DB_NAME: ${db_hostname}
      WORDPRESS_DB_PASSWORD: ${db_password}
      WORDPRESS_DB_USER: ${db_user}
      WORDPRESS_TABLE_PREFIX: wp_
      WORDPRESS_ADMIN_EMAIL: admin@admin.com
      WORDPRESS_ADMIN_PASSWORD: <@generateRandomString(<8>)>
      WORDPRESS_ADMIN_USER: admin
      WORDPRESS_DEBUG: "true"
      WORDPRESS_DEBUG_DISPLAY: "true"
      WORDPRESS_STORAGE_URL: ${storage_apiUrl}
      WORDPRESS_STORAGE_KEY_ID: ${storage_accessKeyId}
      WORDPRESS_STORAGE_ACCESS_KEY: ${storage_secretAccessKey}
      WORDPRESS_STORAGE_BUCKET_NAME: storage
      WORDPRESS_STORAGE_BUCKET: ${storage_serviceId|lower}.${WORDPRESS_STORAGE_BUCKET_NAME}
      WORDPRESS_AUTH_KEY: <@generateRandomString(<64>)>
      WORDPRESS_AUTH_SALT: <@generateRandomString(<64>)>
      WORDPRESS_LOGGED_IN_KEY: <@generateRandomString(<64>)>
      WORDPRESS_LOGGED_IN_SALT: <@generateRandomString(<64>)>
      WORDPRESS_NONCE_KEY: <@generateRandomString(<64>)>
      WORDPRESS_NONCE_SALT: <@generateRandomString(<64>)>
      WORDPRESS_SECURE_AUTH_KEY: <@generateRandomString(<64>)>
      WORDPRESS_SECURE_AUTH_SALT: <@generateRandomString(<64>)>
      WORDPRESS_REDIS_USER_SESSION_HOST: redis
```
