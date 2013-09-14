<?php

/**
/* @author Walker Gusmão - walker@praiseweb.com.br
/* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
*/

/*
 * Example usage
 * $Pagination = new Pagination();
 * $Pagination->num_results = $product_count;
 * $Pagination->limit = $config->config_values['product']['display_num'];
 * $Pagination->page = $page_num;
 * $Pagination->menu_link = '/category/electrical';
 * $Pagination->menu_link_suffix = '/foo/bar'; ( optional )
 * $Pagination->css_class = 'fubar'; ( optional )
 * $Pagination->run();
 * echo $Pagination;
 *
*/

class Pagination {

        /**
        *
        * Constructor, duh!
        *
        * @access       public
        * @param        $num_pages
        * @param        $limit
        * @param        $page
        *
        */
        public function __construct( $num_results=null, $limit=null, $page=null )
        {
                if( !is_null( $num_results ) && !is_null( $limit ) && !is_null( $page ) )
                {
                        $this->num_results = $num_results;
                        $this->limit = $limit;
                        $this->page = $page;
                        $this->run();
                }
        }

        /**
        *
        * Settor
        *
        * @param        string  $name
        * @param        mixed   $value
        *
        */
        public function __set( $name, $value )
        {
                switch( $name )
                {
                        case 'menu_link_suffix':
                        case 'num_results':
                        case 'menu_link':
                        case 'css_class':
                        case 'num_pages':
                        case 'offset':
                        case 'limit':
                        case 'page':
                        $this->$name = $value;
                        break;

                        default: throw new \Exception( "Unable to set $name" );
                }
        }

        /**
        *
        * Gettor
        *
        * @param        string  $name
        *
        */
        public function __get( $name )
        {
                switch( $name )
                {
                        case 'menu_link_suffix':
                        case 'num_results':
                        case 'menu_link':
                        case 'css_class':
                        case 'num_pages':
                        case 'offset':
                        case 'limit':
                        case 'page':
                        return $this->$name;
                        break;

                        default: throw new \Exception( "Unable to get $name" );
                }
        }

        /**
         * @calculate paging information
         *
         * @access public
         * @param int $num_pages
         * @param int $limit
         * @param $page
         * @return object
         *
         **/
        public function run()
        {
                /*** the number of pages ***/
                $this->num_pages = ceil( $this->num_results / $this->limit );
                $this->page = max( $this->page, 1 );
                $this->page = min( $this->page, $this->num_pages );
                /*** calculate the offset ***/
                $this->offset = ( $this->page - 1 ) * $this->limit;
        }

        /**
        *
        * return a HTML string representation of the Pagination links
        * The links are in an <ul> with a CSS class name
        *
        * @access       public
        * @retun        string
        *
        */
        public function __toString()
        {
                $menu = '<ul';
                $menu .= isset( $this->css_class ) ? ' class="'.$this->css_class.'"' : '';
                $menu .= '>';

                /*** if this is page 1 there is no previous link ***/
                if($this->page != 1)
                {
                        $menu .= '<li><a href="'.$this->menu_link.'&page='.( $this->page - 1 );
                        $menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
                        $menu .= '">PREV</a></li>';
                }

                /*** loop over the pages ***/
                for( $i = 1; $i <= $this->num_pages; $i++ )
                {
                        if( $i == $this->page )
                        {
                                $menu .= '<li class="active"><a href="'.$this->menu_link.'&page='.$i;
                                $menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
                                $menu .= '">'.$i.'</a></li>';
                        }
                        else
                        {
                                $menu .= '<li><a href="'.$this->menu_link.'&page='.$i;
                                $menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
                                $menu .= '">'.$i.'</a></li>';
                        }
                }

                /*** if we are on the last page, we do not need the NEXT link ***/
                if( $this->page < $this->num_pages )
                {
                        $menu .= '<li><a href="'.$this->menu_link.'&page='.( $this->page + 1 );
                        $menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
                        $menu .= '">Next</a></li>';
                }
                return $menu;
        }

} /*** end of class ***/
?>
