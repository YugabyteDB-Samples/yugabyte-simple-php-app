# Simple PHP Application for YugabyteDB

This application connects to your YugabyteDB instance via the 
[php-pgsql](https://www.php.net/manual/en/book.pgsql.php) driver for PostgreSQL and performs basic SQL operations. The instructions below are provided for [Yugabyte Cloud](https://cloud.yugabyte.com/) deployments. 
If you use a different type of deployment, then update the `sample-app.php` file with proper connection parameters.

## Prerequisite

* PHP runtime - the sample project was created with PHP 8.1 but should work with earlier and later versions.
* Command line tool or your favourite IDE, such as Visual Studio Code.

## Start Yugabyte Cloud Cluster

* [Start YugabyteDB Cloud](https://docs.yugabyte.com/latest/yugabyte-cloud/cloud-quickstart/qs-add/) instance. You can use
the free tier at no cost.
* Add an IP address of your machine/laptop to the [IP allow list](https://docs.yugabyte.com/latest/yugabyte-cloud/cloud-secure-clusters/add-connections/#manage-ip-allow-lists)

## Clone Application Repository

Clone the repository and change dirs into it:

```bash
git clone https://github.com/yugabyte/yugabyte-simple-php-app && cd yugabyte-simple-php-app
```

## Provide Yugabyte Cloud Connection Parameters

Set the following connection parameters in the `sample-app.php` file:
* `HOST` - the hostname of your YugabyteDB Cloud instance.
* `USER` - the username for your database.
* `PASSWORD` - the password for your database.
* `SSL_MODE`  - an SSL mode. Make sure it's set to `verify-full`.
* `SSL_ROOT_CERT` - a full path to your CA root cert (for example, `/Users/dmagda/certificates/root.crt`). 

Note, you can easily find all the settings on the Yugabyte Cloud dashboard:

![image](resources/cloud_app_settings.png)

## Run the Application
 
1. Install the [php-pgsql](https://www.php.net/manual/en/book.pgsql.php) driver:
    * Homebrew users of version PHP 7.2+: the driver is installed automatically with the `brew install php` command.
    * Ubuntu users can install with the `sudo apt-get install php-pgsql` command.
    * CentOS users can install with the `sudo yum install php-pgsql` command.
    * Others need to follow the [php-pgsql installation guide](https://www.php.net/manual/en/pgsql.setup.php).

3. Run the application:
    ```bash
    php sample-app.php
    ```

Upon successful execution, you will see output similar to the following:

```bash
>>>> Connecting to YugabyteDB!
>>>> Successfully connected to YugabyteDB!
>>>> Successfully created table DemoAccount.
>>>> Selecting accounts:
name=Jessica, age=28, country=USA, balance=10000
name=John, age=28, country=Canada, balance=9000
>>>> Transferred 800 between accounts
>>>> Selecting accounts:
name=Jessica, age=28, country=USA, balance=9200
name=John, age=28, country=Canada, balance=9800
```

## Explore Application Logic

Congrats! You've successfully executed a simple PHP app that works with Yugabyte Cloud.

Now, explore the source code of `sample-app.php`:
1. `connect` function - establishes a connection with your cloud instance via the php-pgsql driver.
3. `create_database` function - creates a table and populates it with sample data.
4. `select_accounts` function - queries the data with SQL `SELECT` statements.
5. `transfer_money_between_accounts` function - updates records consistently with distributed transactions.

## Questions or Issues?

Having issues running this application or want to learn more from Yugabyte experts?

Join [our Slack channel](https://communityinviter.com/apps/yugabyte-db/register),
or raise a question on StackOverflow and tag the question with `yugabytedb`!