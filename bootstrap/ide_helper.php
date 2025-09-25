<?php

/**
 * IDE Helper Functions for Laravel
 * This file helps IDEs understand Laravel's global helper functions
 */

if (!function_exists('redirect')) {
  /**
   * Get an instance of the redirector.
   *
   * @param  string|null  $to
   * @param  int  $status
   * @param  array  $headers
   * @param  bool|null  $secure
   * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
   */
  function redirect($to = null, $status = 302, $headers = [], $secure = null)
  {
    //
  }
}

if (!function_exists('response')) {
  /**
   * Return a new response from the application.
   *
   * @param  \Illuminate\Contracts\View\View|string|array|null  $content
   * @param  int  $status
   * @param  array  $headers
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  function response($content = '', $status = 200, array $headers = [])
  {
    //
  }
}

if (!function_exists('view')) {
  /**
   * Get the evaluated view contents for the given view.
   *
   * @param  string|null  $view
   * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
   * @param  array  $mergeData
   * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
   */
  function view($view = null, $data = [], $mergeData = [])
  {
    //
  }
}

if (!function_exists('route')) {
  /**
   * Generate the URL to a named route.
   *
   * @param  array|string  $name
   * @param  mixed  $parameters
   * @param  bool  $absolute
   * @return string
   */
  function route($name, $parameters = [], $absolute = true)
  {
    //
  }
}

if (!function_exists('asset')) {
  /**
   * Generate an asset path for the application.
   *
   * @param  string  $path
   * @param  bool|null  $secure
   * @return string
   */
  function asset($path, $secure = null)
  {
    //
  }
}

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed|\Illuminate\Config\Repository
     */
    function config($key = null, $default = null)
    {
        //
    }
}

// Eloquent Builder method stubs for IDE support
if (!class_exists('EloquentBuilderStub')) {
    /**
     * @mixin \Illuminate\Database\Eloquent\Builder
     */
    class EloquentBuilderStub
    {
        /**
         * @return int
         */
        public function count()
        {
            return 0;
        }

        /**
         * @param string $column
         * @param string $operator
         * @param mixed $value
         * @return $this
         */
        public function where($column, $operator = null, $value = null)
        {
            return $this;
        }

        /**
         * @param string $column
         * @param array $values
         * @return $this
         */
        public function whereIn($column, $values)
        {
            return $this;
        }

        /**
         * @param string $column
         * @return \Illuminate\Support\Collection
         */
        public function pluck($column)
        {
            return new \Illuminate\Support\Collection();
        }

        /**
         * @param string $column
         * @return float|int
         */
        public function sum($column)
        {
            return 0;
        }
    }
}