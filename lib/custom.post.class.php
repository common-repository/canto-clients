<?php
/**
* Custom Post type Class
* 
*/
if (!class_exists('Canto_CustomPostType')) {
	class Canto_CustomPostType{
		//Properties

		private $pTypeArgs = array();
		private $TXTDOMAIN = '';
		/*
		$this->ptype_txtDomain = $textDomain;
			$this->ptype_postTypeName = strtolower($postType);
			if($icon != ''){
				$this->setIcon($icon, $IconOnAdminDir);
			}
		*/


		/*
			Every Args listed here
			* postType - Post Type
			* txtdomain - Theme Text Domain
			* pTypeMenuName - Post Type Menu Name in labels
			* postTypeDesc - Post Type Description
			* postTypePublic - Post Type is Public or not
			* pTypePQueryable - Publically Queryable
			* pTypePExSearch - Exclude From Search
			* pTypePShowUI - Show UI
			* pTypeShowMenu - Show in Menu
			* pTypeMenuPos - Post Type Menu Position
			* pTypeIconURL - Post Type Icon URL
			* pTypeHierarchical - Whether the post type is hierarchical. Allows Parent to be specified. 
			* pTypeSupport (***) - (array) - Post Type Support
			* pTypeHasArchive -  Enables post type archives. Will use string as archive slug. Will generate the proper rewrite rules if rewrite is enabled.
			* pTypeRewrite (***) -(array)- Post Type rewrite args 
			* pTypeShowInNavMenu - Post Type show in nav menu
		*/

		//Constrator Method ($postType, $textDomain, $icon = '', $IconOnAdminDir = false)
		function __construct($args = array()){
			
			$this->pTypeArgs = $args;

			$this->TXTDOMAIN = $this->pTypeArgs['txtdomain'];

			$this->registerPostType();
		}

		//Register Post type
		private function registerPostType(){
			$postType = ucfirst($this->pTypeArgs['postType']);
			$postTypeDesc = $this->pTypeArgs['postTypeDesc'];
			$public = $this->pTypeArgs['postTypePublic'];

			//Menu Name
			$menuName = __($postType, $this->TXTDOMAIN);
			if (isset($this->pTypeArgs['pTypeMenuName'])) {
				$menuName = __($this->pTypeArgs['pTypeMenuName'], $this->TXTDOMAIN);
			}
			$args = array(
				'labels' => array(
		               'name' => __($postType, $this->TXTDOMAIN),
		               'singular_name'  => __($postType, $this->TXTDOMAIN),
		               'add_new' => __('Add New', $this->TXTDOMAIN),
		               'add_new_item' => __('Add New',$this->TXTDOMAIN),
		               'edit_item' => __('Edit', $this->TXTDOMAIN),
		               'new_item' => __('Add New', $this->TXTDOMAIN),
		               'view_item' => __('View', $this->TXTDOMAIN),
		               'search_item' => __('Search ' . $postType, $this->TXTDOMAIN),
		               'not_found' => __('No ' . $postType . ' Found', $this->TXTDOMAIN),
		               'not_found_in_trash' => __('No ' . $postType . ' Found in Trush', $this->TXTDOMAIN),
		               'menu_name' => $menuName
		           ),
					'description' => $postTypeDesc,
		           'query_var' => isset($this->pTypeArgs['postType']) ? strtolower($this->pTypeArgs['postType']) : true,
		           'rewrite' => $this->pTypeArgs['pTypeRewrite'],
		           'public' => isset($public) ? $public : false,
		           'publicly_queryable' => isset($this->pTypeArgs['pTypePQueryable']) ? $this->pTypeArgs['pTypePQueryable'] : $public,
		           'exclude_from_search' => isset($this->pTypeArgs['pTypePExSearch']) ? $this->pTypeArgs['pTypePExSearch'] : $public,
		           'show_ui' => isset($this->pTypeArgs['pTypePShowUI']) ? $this->pTypeArgs['pTypePShowUI'] : $public,
		           'show_in_nav_menus' => isset($this->pTypeArgs['pTypeShowInNavMenu']) ? $this->pTypeArgs['pTypeShowInNavMenu'] : $public,
		           'show_in_menu' => isset($this->pTypeArgs['pTypeShowMenu']) ? $this->pTypeArgs['pTypeShowMenu'] : null,
		           'menu_position' => isset($this->pTypeArgs['pTypeMenuPos']) ? $this->pTypeArgs['pTypeMenuPos'] : null,
		           'supports' => $this->pTypeArgs['pTypeSupport'],
		           'menu_icon' => isset($this->pTypeArgs['pTypeIconURL']) ? $this->pTypeArgs['pTypeIconURL'] : null,
		           'hierarchical' => isset($this->pTypeArgs['pTypeHierarchical']) ? $this->pTypeArgs['pTypeHierarchical'] : false,
		           'has_archive' => isset($this->pTypeArgs['pTypeHasArchive']) ? $this->pTypeArgs['pTypeHasArchive'] : false
				);
			register_post_type(strtolower($this->pTypeArgs['postType']), $args);
		}
		public function getPostType(){
			$r = '';
			$r = strtolower($this->pTypeArgs['postType']);

			return $r;
		}

		public function getTxtDomain(){
			$r = '';
			$r = $this->TXTDOMAIN;

			return $r;
		}
	}
}

?>