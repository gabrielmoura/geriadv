<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use League\Flysystem\Filesystem;
class OtherStorageServiceProvider extends ServiceProvider
{
  


    public function boot()
    {
        // BackblazeAdapter
        if (class_exists('\Mhetreramesh\Flysystem\BackblazeAdapter')) {
            Storage::extend('backblaze', function ($app, $config) {
                return new Filesystem(new \Mhetreramesh\Flysystem\BackblazeAdapter(new \BackblazeB2\Client($config['account_id'], $config['application_key']), $config['bucket']), $config);
            });
        }
        
        // OneDriveAdapter
        if (class_exists('\Ignited\Flysystem\OneDrive\OneDriveAdapter')) {
            Storage::extend('onedrive', function ($app, $config) {
                $oneConfig = Arr::only($config, ['base_url', 'access_token']);
                if ($config['use_logger']) {
                    $logger = Log::getMonolog();
                } else {
                    $logger = null;
                }

                return new Filesystem(new \Ignited\Flysystem\OneDrive\OneDriveAdapter(\Ignited\Flysystem\OneDrive\OneDriveClient::factory($oneConfig, $logger)), $config);
            });
        } elseif (class_exists('\JacekBarecki\FlysystemOneDrive\Adapter\OneDriveAdapter')) {
            Storage::extend('onedrive', function ($app, $config) {
                return new Filesystem(new \JacekBarecki\FlysystemOneDrive\Adapter\OneDriveAdapter(new \JacekBarecki\FlysystemOneDrive\Client\OneDriveClient(Arr::get($config, 'access_token'), new \GuzzleHttp\Client())), $config);
            });
        } elseif (class_exists('\NicolasBeauvais\FlysystemOneDrive\OneDriveAdapter')) {
            Storage::extend('onedrive', function ($app, $config) {
                $graph = new \Microsoft\Graph\Graph();
                $graph->setAccessToken($config['access_token']);

                return new Filesystem(new \NicolasBeauvais\FlysystemOneDrive\OneDriveAdapter($graph, Arr::get($config, 'root', 'root')), $config);
            });
        }

        // DropboxAdapter
        if (class_exists('\Spatie\FlysystemDropbox\DropboxAdapter')) {
            Storage::extend('dropbox', function ($app, $config) {
                $client = new \Spatie\Dropbox\Client($config['authToken']);
                return new Filesystem(new \Spatie\FlysystemDropbox\DropboxAdapter($client), $config);
            });
        } elseif (class_exists('\Srmklive\Dropbox\Adapter\DropboxAdapter')) {
            Storage::extend('dropbox', function ($app, $config) {
                $client = new \Srmklive\Dropbox\Client\DropboxClient($config['authToken']);
                return new Filesystem(new \Srmklive\Dropbox\Adapter\DropboxAdapter($client), $config);
            });
        }

        if (class_exists('\PrivateIT\FlySystem\GoogleDrive\GoogleDriveAdapter')) {
            Storage::extend('gdrive', function ($app, $config) {
                $client = new \Google_Client();
                $client->setClientId($config['client_id']);
                $client->setClientSecret($config['secret']);
                $client->refreshToken($config['token']);

                $adapter = new \PrivateIT\FlySystem\GoogleDrive\GoogleDriveAdapter(new \Google_Service_Drive($client), Arr::get($config, 'root', null));
                $adapter->setPathManager(new GoogleSheetsPathManager(new \Google_Service_Sheets($client), Arr::get($config, $config, 'paths_sheet', null), $this->disk(Arr::get($config, 'paths_cache_drive', config('filesystems.default')))));

                return new Filesystem($adapter, $config);
            });
        } elseif (class_exists('\Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter')) {
            Storage::extend('gdrive', function ($app, $config) {
                $client = new \Google_Client();
                $client->setClientId($config['client_id']);
                $client->setClientSecret($config['secret']);
                $client->refreshToken($config['token']);

                return new Filesystem(new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter(new \Google_Service_Drive($client), Arr::get($config, 'root', null)), $config);
            });
        } elseif (class_exists('\Ignited\Flysystem\GoogleDrive\GoogleDriveAdapter')) {
            Storage::extend('gdrive', function ($app, $config) {
                $client = new \Google_Client();
                $client->setClientId($config['client_id']);
                $client->setClientSecret($config['secret']);
                $client->setAccessToken(json_encode([
                    "access_token" => $config['token'],
                    "expires_in"   => 3920,
                    "token_type"   => "Bearer",
                    "created"      => time()
                ]));

                return new Filesystem(new \Ignited\Flysystem\GoogleDrive\GoogleDriveAdapter(new \Google_Service_Drive($client)), $config);
            });
        }
    }
}
