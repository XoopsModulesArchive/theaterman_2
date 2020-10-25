<?php
//----------------------------------------------------------------------------
  // gt_cache
  //
  // by Joby Elliott
  // www.greentinted.net
  //
  // a class for handling caching of page output, so that you can make your
  // scripts run faster and cheaper.
  //
  //----------------------------------------------------------------------------
  //
  // Requirements:
  //  - gt_data class started as $gt_data
  //
  //----------------------------------------------------------------------------
  // USEAGE EXAMPLE
  //----------------------------------------------------------------------------
  //
  //  $gt_shortcache = new gt_cache();
  //  $gt_shortcache->set_path("cache/");
  //  $gt_shortcache->set_prefix("cache_short_");
  //  $gt_shortcache->set_lifetime("60");
  //
  //  if ($gt_shortcache->start("test")) {  //checks if cache "test" needs updating
  //    //put whatever code you want cached in here
  //    echo "this will be cached for 60 seconds";
  //
  //    $gt_shortcache->stop("test"); //adds whatever has been output since the
  //  }                               //last start to cache "test"
  //
  //----------------------------------------------------------------------------
  // a note on ordering
  // this class uses PHP's standard ob_start() and ob_end_flush() functions, so
  // different caches MUST be nested correctly (like HTML tags).  Also, if you
  // do nest them like this, don't forget that the nested ones (cache2 in the
  // first example), will not be updated until their parent is updated (cache1
  // in the first example).  So if you set the lifetime of cache2 to 60 seconds
  // and the lifetime of cache to 600, you have effectively made the lifetime
  // of cache2 600 also.
  //-right----------------------------------------------------------------------
  //
  //  $gt_shortcache->start("cache1");
  //    $gt_shortcache->start("cache2");
  //    $gt_shortcache->stop("cache2");
  //  $gt_shortcache->stop("cache1");
  //  $gt_shortcache->start("cache3");
  //  $gt_shortcache->stop("cache3");
  //
  //-wrong----------------------------------------------------------------------
  //
  //    $gt_shortcache->start("cache2");
  //  $gt_shortcache->start("cache1");
  //    $gt_shortcache->stop("cache2");
  //  $gt_shortcache->stop("cache1");
  //  $gt_shortcache->start("cache3");
  //  $gt_shortcache->stop("cache3");
  //
  //----------------------------------------------------------------------------
  class gt_cache
  {
      public $path;

      public $prefix;

      public $lifetime;

      public $data;

      public function __construct()
      {
          global $gt_data;

          $this->set_path('cache/syscache/');

          $this->set_prefix('gt_cache_');

          $this->set_lifetime(60);

          $this->data = $gt_data->read('gt_cache_data');
      }

      public function set_path($input)
      {
          $this->path = $input;

          return(1);
      }

      public function set_prefix($input)
      {
          $this->prefix = $input;

          return(1);
      }

      public function set_lifetime($input)
      {
          $this->lifetime = $input;

          return(1);
      }

      public function start($name)
      {
          global $gt_error, $gt_data;

          $gt_error->set_system('gt_cache');

          $fname = $this->path . $this->prefix . $name . '.gtcsh';

          $name = $name;

          if (is_file($fname)) {
              if (isset($this->data[$name])) {
                  //WHOOO!!! everything is set up, proceed to load cache

                  if (time() > $this->data[$name]) {
                      //cache has expired

                      ob_start();
                  } else {
                      //cache has not expired

                      echo implode('', file($fname));

                      $gt_error->new_error('debug', "cache file <i>$fname</i> will be refreshed in " . ($this->data[$name] - time()) . ' seconds');

                      return(0);
                  }
              } else {
                  //file doesn't have an expiration time

                  $gt_error->new_error('notice', "cache file <i>$fname</i> does not have an expiration (name= $name value= " . (time() + $this->lifetime) . '), attempting to create');

                  $this->data[$name] = time() + $this->lifetime;

                  if ($gt_data->write('gt_cache_data', $this->data)) {
                  } else {
                      $gt_error->new_error('notice', 'cache_data could not be written');
                  }

                  ob_start();
              }
          } else {
              //file doesn't exist

              $gt_error->new_error('notice', "cache file <i>$fname</i> does not exist, attempting to create");

              $this->data[$name] = time() + $this->lifetime;

              $file = fopen($fname, 'w+b');

              fclose($file);

              ob_start();
          }

          $data = $this->data;

          $gt_data->write('gt_cache_data', $data);

          return(1);
      }

      public function stop($name)
      {
          global $gt_error, $gt_data;

          $gt_error->set_system('gt_cache');

          $fname = $this->path . $this->prefix . $name . '.gtcsh';

          $cachedata = ob_get_contents();

          ob_end_flush();

          $file = fopen($fname, 'w+b');

          fwrite($file, $cachedata);

          fclose($file);

          $gt_error->new_error('debug', "cache file <i>$fname</i> has been updated, first time in " . (time() - ($this->data[$name] + $this->lifetime)) . ' seconds');

          $this->data[$name] = time() + $this->lifetime;

          $gt_data->write('gt_cache_data', $this->data);
      }

      public function kill($name)
      {
          if (isset($this->data['name'])) {
              unset($this->data['name']);

              $gt_data->write('gt_cache_data', $this->data);
          }

          if (is_file($this->path . $this->prefix . $name . '.gtcsh')) {
              unlink($this->path . $this->prefix . $name . '.gtcsh');
          }
      }
  }
