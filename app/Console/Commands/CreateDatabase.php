<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create database for project ';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        try {

            $pdo = new \PDO('mysql:host=' . env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'));

            $charset = config("database.connections.mysql.charset", 'utf8mb4');

            $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');

            $query = "CREATE DATABASE IF NOT EXISTS " . env('DB_DATABASE') . " CHARACTER SET $charset COLLATE $collation;";

            $pdo->exec($query);
            $this->info("Database created! ");
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            throw $exception;
        }
    }
}
