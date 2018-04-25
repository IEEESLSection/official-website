<?php 

if ( ! function_exists( 'alchem_display_by_type' ) ) {

  function alchem_display_by_type( $args = array() ) {
    
    /* allow filters to be executed on the array */
    $args = apply_filters( 'alchem_display_by_type', $args );
    
    /* build the function name */
    $function_name_by_type = str_replace( '-', '_', 'alchem_type_' . $args['type'] );
    
    /* call the function & pass in arguments array */
    if ( function_exists( $function_name_by_type ) ) {
      call_user_func( $function_name_by_type, $args );
	  
    } else {
      echo '<p>' . __( 'Sorry, this function does not exist', 'alchem' ) . '</p>';
    }
    
  }
  
}

/**
 * Background option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_background' ) ) {
  
  function alchem_type_background( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-background ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $alchem_recognized_background_fields = apply_filters( 'alchem_recognized_background_fields', array( 
          'background-color',
          'background-repeat', 
          'background-attachment', 
          'background-position',
          'background-size',
          'background-image'
        ), $field_id );
        
        echo '<div class="alchem-background-group">';
        
          /* build background color */
          if ( in_array( 'background-color', $alchem_recognized_background_fields ) ) {
          
            echo '<div class="option-tree-ui-colorpicker-input-wrap">';
              
              /* colorpicker JS */      
              echo '<script>jQuery(document).ready(function($) { ALCHEM_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
              
              /* set background color */
              $background_color = isset( $field_value['background-color'] ) ? esc_attr( $field_value['background-color'] ) : '';
              
              /* input */
              echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-color]" id="' . $field_id . '-picker" value="' . $background_color . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
            
            echo '</div>';
          
          }
      
          /* build background repeat */
          if ( in_array( 'background-repeat', $alchem_recognized_background_fields ) ) {
          
            $background_repeat = isset( $field_value['background-repeat'] ) ? esc_attr( $field_value['background-repeat'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-repeat]" id="' . esc_attr( $field_id ) . '-repeat" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
              echo '<option value="">' . __( 'background-repeat', 'alchem' ) . '</option>';
              foreach ( alchem_recognized_background_repeat( $field_id ) as $key => $value ) {
              
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_repeat, $key, false ) . '>' . esc_attr( $value ) . '</option>';
                
              }
              
            echo '</select>';
          
          }
          
          /* build background attachment */
          if ( in_array( 'background-attachment', $alchem_recognized_background_fields ) ) {
          
            $background_attachment = isset( $field_value['background-attachment'] ) ? esc_attr( $field_value['background-attachment'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-attachment]" id="' . esc_attr( $field_id ) . '-attachment" class="option-tree-ui-select ' . $field_class . '">';
              
              echo '<option value="">' . __( 'background-attachment', 'alchem' ) . '</option>';
              
              foreach ( alchem_recognized_background_attachment( $field_id ) as $key => $value ) {
              
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_attachment, $key, false ) . '>' . esc_attr( $value ) . '</option>';
              
              }
              
            echo '</select>';
          
          }
          
          /* build background position */
          if ( in_array( 'background-position', $alchem_recognized_background_fields ) ) {
          
            $background_position = isset( $field_value['background-position'] ) ? esc_attr( $field_value['background-position'] ) : '';
            
            echo '<select name="' . esc_attr( $field_name ) . '[background-position]" id="' . esc_attr( $field_id ) . '-position" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
              echo '<option value="">' . __( 'background-position', 'alchem' ) . '</option>';
              
              foreach ( alchem_recognized_background_position( $field_id ) as $key => $value ) {
                
                echo '<option value="' . esc_attr( $key ) . '" ' . selected( $background_position, $key, false ) . '>' . esc_attr( $value ) . '</option>';
              
              }
            
            echo '</select>';
          
          }
  
          /* Build background size  */
          if ( in_array( 'background-size', $alchem_recognized_background_fields ) ) {
            
            /**
             * Use this filter to create a select instead of an text input.
             * Be sure to return the array in the correct format. Add an empty 
             * value to the first choice so the user can leave it blank.
             *
                array( 
                  array(
                    'label' => 'background-size',
                    'value' => ''
                  ),
                  array(
                    'label' => 'cover',
                    'value' => 'cover'
                  ),
                  array(
                    'label' => 'contain',
                    'value' => 'contain'
                  )
                )
             *
             */
            $choices = apply_filters( 'alchem_type_background_size_choices', '', $field_id );
            
            if ( is_array( $choices ) && ! empty( $choices ) ) {
            
              /* build select */
              echo '<select name="' . esc_attr( $field_name ) . '[background-size]" id="' . esc_attr( $field_id ) . '-size" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
              
                foreach ( (array) $choices as $choice ) {
                  if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
                    echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $field_value['background-size'], $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
                  }
                }
        
              echo '</select>';
            
            } else {
            
              echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-size]" id="' . esc_attr( $field_id ) . '-size" value="' . ( isset( $field_value['background-size'] ) ? esc_attr( $field_value['background-size'] ) : '' ) . '" class="widefat alchem-background-size-input option-tree-ui-input ' . esc_attr( $field_class ) . '" placeholder="' . __( 'background-size', 'alchem' ) . '" />';
              
            }
          
          }
        
        echo '</div>';

        /* build background image */
        if ( in_array( 'background-image', $alchem_recognized_background_fields ) ) {
        
          echo '<div class="option-tree-ui-upload-parent">';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[background-image]" id="' . esc_attr( $field_id ) . '" value="' . ( isset( $field_value['background-image'] ) ? esc_attr( $field_value['background-image'] ) : '' ) . '" class="widefat option-tree-ui-upload-input ' . esc_attr( $field_class ) . '" />';
            
            /* add media button */
            echo '<a href="javascript:void(0);" class="alchem_upload_media option-tree-ui-button button button-primary light" rel="' . $post_id . '" title="' . __( 'Add Media', 'alchem' ) . '"><span class="icon alchem-icon-plus-sign"></span>' . __( 'Add Media', 'alchem' ) . '</a>';
          
          echo '</div>';
          
          /* media */
          if ( isset( $field_value['background-image'] ) && $field_value['background-image'] !== '' ) {
          
            echo '<div class="option-tree-ui-media-wrap" id="' . esc_attr( $field_id ) . '_media">';
            
              if ( preg_match( '/\.(?:jpe?g|png|gif|ico)$/i', $field_value['background-image'] ) )
                echo '<div class="option-tree-ui-image-wrap"><img src="' . esc_url( $field_value['background-image'] ) . '" alt="" /></div>';
              
              echo '<a href="javascript:(void);" class="option-tree-ui-remove-media option-tree-ui-button button button-secondary light" title="' . __( 'Remove Media', 'alchem' ) . '"><span class="icon alchem-icon-minus-sign"></span>' . __( 'Remove Media', 'alchem' ) . '</a>';
              
            echo '</div>';
            
          }
        
        }

      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Category Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_category_checkbox' ) ) {
  
  function alchem_type_category_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-category-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* get category array */
        $categories = get_categories( apply_filters( 'alchem_type_category_checkbox_query', array( 'hide_empty' => false ), $field_id ) );
        
        /* build categories */
        if ( ! empty( $categories ) ) {
          foreach ( $categories as $category ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $category->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $category->term_id ) . '" value="' . esc_attr( $category->term_id ) . '" ' . ( isset( $field_value[$category->term_id] ) ? checked( $field_value[$category->term_id], $category->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $category->term_id ) . '">' . esc_attr( $category->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . __( 'No Categories Found', 'alchem' ) . '</p>';
        }
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Category Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_category_select' ) ) {
  
  function alchem_type_category_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-category-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build category */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* get category array */
        $categories = get_categories( apply_filters( 'alchem_type_category_select_query', array( 'hide_empty' => false ), $field_id ) );
        
        /* has cats */
        if ( ! empty( $categories ) ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach ( $categories as $category ) {
            echo '<option value="' . esc_attr( $category->term_id ) . '"' . selected( $field_value, $category->term_id, false ) . '>' . esc_attr( $category->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Categories Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_checkbox' ) ) {
  
  function alchem_type_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';    
      
        /* build checkbox */
        foreach ( (array) $field_choices as $key => $choice ) {
          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $key ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '" ' . ( isset( $field_value[$key] ) ? checked( $field_value[$key], $choice['value'], false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label>';
            echo '</p>';
          }
        }
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Colorpicker option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 * @updated   2.2.0
 */
if ( ! function_exists( 'alchem_type_colorpicker' ) ) {
  
  function alchem_type_colorpicker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-colorpicker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* build colorpicker */  
        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
          
          /* colorpicker JS */      
          echo '<script>jQuery(document).ready(function($) { ALCHEM_UI.bind_colorpicker("' . esc_attr( $field_id ) . '"); });</script>';
          
          /* set the default color */
          $std = $field_std ? 'data-default-color="' . $field_std . '"' : '';
          
          /* input */
          echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" ' . $std . ' />';
        
        echo '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * CSS option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_css' ) ) {
  
  function alchem_type_css( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-css simple ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* build textarea for CSS */
        echo '<textarea class="hidden" id="textarea_' . esc_attr( $field_id ) . '" name="' . esc_attr( $field_name ) .'">' . esc_attr( $field_value ) . '</textarea>';
    
        /* build pre to convert it into ace editor later */
        echo '<pre class="alchem-css-editor ' . esc_attr( $field_class ) . '" id="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</pre>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Custom Post Type Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_custom_post_type_checkbox' ) ) {
  
  function alchem_type_custom_post_type_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-custom-post-type-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* setup the post types */
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );

        /* query posts array */
        $my_posts = get_posts( apply_filters( 'alchem_type_custom_post_type_checkbox_query', array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );

        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
            echo '</p>';
          }
        } else {
          echo '<p>' . __( 'No Posts Found', 'alchem' ) . '</p>';
        }
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Custom Post Type Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_custom_post_type_select' ) ) {
  
  function alchem_type_custom_post_type_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-custom-post-type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* build category */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* setup the post types */
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
        
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'alchem_type_custom_post_type_select_query', array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Posts Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Date Picker option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3
 */
if ( ! function_exists( 'alchem_type_date_picker' ) ) {
  
  function alchem_type_date_picker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* filter date format */
    $date_format = apply_filters( 'alchem_type_date_picker_date_format', 'yy-mm-dd', $field_id );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-date-picker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    
    /* date picker JS */      
    echo '<script>jQuery(document).ready(function($) { ALCHEM_UI.bind_date_picker("' . esc_attr( $field_id ) . '", "' . esc_attr( $date_format ) . '"); });</script>';      
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build date picker */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Date Time Picker option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3
 */
if ( ! function_exists( 'alchem_type_date_time_picker' ) ) {
  
  function alchem_type_date_time_picker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* filter date format */
    $date_format = apply_filters( 'alchem_type_date_time_picker_date_format', 'yy-mm-dd', $field_id );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-date-time-picker ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    
    /* date time picker JS */      
    echo '<script>jQuery(document).ready(function($) { ALCHEM_UI.bind_date_time_picker("' . esc_attr( $field_id ) . '", "' . esc_attr( $date_format ) . '"); });</script>';      
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build date time picker */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Gallery option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The gallery metabox markup.
 *
 * @access    public
 * @since     2.2.0
 */
if ( ! function_exists( 'alchem_type_gallery' ) ) {

  function alchem_type_gallery( $args = array() ) {
  
    // Turns arguments array into variables
    extract( $args );
  
    // Verify a description
    $has_desc = $field_desc ? true : false;
  
    // Format setting outer wrapper
    echo '<div class="format-setting type-gallery ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
  
      // Description
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
  
      // Format setting inner wrapper
      echo '<div class="format-setting-inner">';
  
        // Setup the post type
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
        
        $field_value = trim( $field_value );
        
        // Saved values
        echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="alchem-gallery-value ' . esc_attr( $field_class ) . '" />';
        
        // Search the string for the IDs
        preg_match( '/ids=\'(.*?)\'/', $field_value, $matches );
        
        // Turn the field value into an array of IDs
        if ( isset( $matches[1] ) ) {
          
          // The string is a shortcode
          $ids = explode( ',', $matches[1] );
          
        } else {
          
          // The string is a comma separated list of IDs
          $ids = ! empty( $field_value ) && $field_value != '' ? explode( ',', $field_value ) : array();
          
        }

        // Has attachment IDs
        if ( ! empty( $ids ) ) {
          
          echo '<ul class="alchem-gallery-list">';
          
          foreach( $ids as $id ) {
            
            if ( $id == '' )
              continue;
              
            $thumbnail = wp_get_attachment_image_src( $id, 'thumbnail' );
        
            echo '<li><img  src="' . $thumbnail[0] . '" width="75" height="75" /></li>';
        
          }
        
          echo '</ul>';
          
          echo '
          <div class="alchem-gallery-buttons">
            <a href="#" class="option-tree-ui-button button button-secondary hug-left alchem-gallery-delete">' . __( 'Delete Gallery', 'alchem' ) . '</a>
            <a href="#" class="option-tree-ui-button button button-primary right hug-right alchem-gallery-edit">' . __( 'Edit Gallery', 'alchem' ) . '</a>
          </div>';
        
        } else {
        
          echo '
          <div class="alchem-gallery-buttons">
            <a href="#" class="option-tree-ui-button button button-primary right hug-right alchem-gallery-edit">' . __( 'Create Gallery', 'alchem' ) . '</a>
          </div>';
        
        }
      
      echo '</div>';
      
    echo '</div>';
    
  }

}

/**
 * List Item option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_list_item' ) ) {
  
  function alchem_type_list_item( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-list-item ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* pass the settings array arround */
        echo '<input type="hidden" name="' . esc_attr( $field_id ) . '_settings_array" id="' . esc_attr( $field_id ) . '_settings_array" value="' . alchem_encode( serialize( $field_settings ) ) . '" />';
        
        /** 
         * settings pages have array wrappers like 'option_tree'.
         * So we need that value to create a proper array to save to.
         * This is only for NON metaboxes settings.
         */
        if ( ! isset( $get_option ) )
          $get_option = '';
          
        /* build list items */
        echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-get-option="' . esc_attr( $get_option ) . '" data-type="' . esc_attr( $type ) . '">';
        
        if ( is_array( $field_value ) && ! empty( $field_value ) ) {
        
          foreach( $field_value as $key => $list_item ) {
            
            echo '<li class="ui-state-default list-list-item">';
              alchem_list_item_view( $field_id, $key, $list_item, $post_id, $get_option, $field_settings, $type );
            echo '</li>';
            
          }
          
        }
        
        echo '</ul>';
        
        /* button */
        echo '<a href="javascript:void(0);" class="option-tree-list-item-add option-tree-ui-button button button-primary right hug-right" title="' . __( 'Add New', 'alchem' ) . '">' . __( 'Add New', 'alchem' ) . '</a>';
        
        /* description */
        echo '<div class="list-item-description">' . apply_filters( 'alchem_list_item_description', __( 'You can re-order with drag & drop, the order will update after saving.', 'alchem' ), $field_id ) . '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Measurement option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_measurement' ) ) {
  
  function alchem_type_measurement( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-measurement ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        echo '<div class="option-tree-ui-measurement-input-wrap">';
        
          echo '<input type="text" name="' . esc_attr( $field_name ) . '[0]" id="' . esc_attr( $field_id ) . '-0" value="' . ( isset( $field_value[0] ) ? esc_attr( $field_value[0] ) : '' ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
        echo '</div>';
        
        /* build measurement */
        echo '<select name="' . esc_attr( $field_name ) . '[1]" id="' . esc_attr( $field_id ) . '-1" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
          
          echo '<option value="">&nbsp;--&nbsp;</option>';
          
          foreach ( alchem_measurement_unit_types( $field_id ) as $unit ) {
            echo '<option value="' . esc_attr( $unit ) . '"' . selected( $field_value[1], $unit, false ) . '>' . esc_attr( $unit ) . '</option>';
          }
          
        echo '</select>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Numeric Slider option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.1
 */
if( ! function_exists( 'alchem_type_numeric_slider' ) ) {

  function alchem_type_numeric_slider( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    $_options = explode( ',', $field_min_max_step );
    $min = isset( $_options[0] ) ? $_options[0] : 0;
    $max = isset( $_options[1] ) ? $_options[1] : 100;
    $step = isset( $_options[2] ) ? $_options[2] : 1;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-numeric-slider ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

        echo '<div class="alchem-numeric-slider-wrap">';

          echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="alchem-numeric-slider-hidden-input" value="' . esc_attr( $field_value ) . '" data-min="' . esc_attr( $min ) . '" data-max="' . esc_attr( $max ) . '" data-step="' . esc_attr( $step ) . '">';

          echo '<input type="text" class="alchem-numeric-slider-helper-input widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" value="' . esc_attr( $field_value ) . '" readonly>';

          echo '<div id="alchem_numeric_slider_' . esc_attr( $field_id ) . '" class="alchem-numeric-slider"></div>';

        echo '</div>';
      
      echo '</div>';
      
    echo '</div>';
  }

}

/**
 * On/Off option type
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     The options arguments
 * @return    string    The gallery metabox markup.
 *
 * @access    public
 * @since     2.2.0
 */
if ( ! function_exists( 'alchem_type_on_off' ) ) {
  
  function alchem_type_on_off( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        // Force choices
        $field_choices = array(
          array(
            'value'   => 'on',
            'label'   => __( 'On', 'alchem' ),
          ),
          array(
            'value'   => 'off',
            'label'   => __( 'Off', 'alchem' ),
          )
        );
        
        echo '<div class="on-off-switch">';
                    
        /* build radio */
        foreach ( (array) $field_choices as $key => $choice ) {
          echo '
            <input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="radio option-tree-ui-radio ' . esc_attr( $field_class ) . '" />
            <label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" onclick="">' . esc_attr( $choice['label'] ) . '</label>';
        }
          
          echo '<span class="slide-button"></span>';
          
        echo '</div>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Page Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_page_checkbox' ) ) {
  
  function alchem_type_page_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-page-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';

      /* query pages array */
      $my_posts = get_posts( apply_filters( 'alchem_type_page_checkbox_query', array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );

      /* has pages */
      if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
        foreach( $my_posts as $my_post ) {
          $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
          echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
          echo '</p>';
        }
      } else {
        echo '<p>' . __( 'No Pages Found', 'alchem' ) . '</p>';
      }
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Page Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_page_select' ) ) {
  
  function alchem_type_page_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-page-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* query pages array */
        $my_posts = get_posts( apply_filters( 'alchem_type_page_select_query', array( 'post_type' => array( 'page' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has pages */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Pages Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * List Item option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_slider' ) ) {
  
  function alchem_type_slider( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-slider ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* pass the settings array arround */
        echo '<input type="hidden" name="' . esc_attr( $field_id ) . '_settings_array" id="' . esc_attr( $field_id ) . '_settings_array" value="' . alchem_encode( serialize( $field_settings ) ) . '" />';
        
        /** 
         * settings pages have array wrappers like 'option_tree'.
         * So we need that value to create a proper array to save to.
         * This is only for NON metaboxes settings.
         */
        if ( ! isset( $get_option ) )
          $get_option = '';
          
        /* build list items */
        echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-get-option="' . esc_attr( $get_option ) . '" data-type="' . esc_attr( $type ) . '">';
        
        if ( is_array( $field_value ) && ! empty( $field_value ) ) {
        
          foreach( $field_value as $key => $list_item ) {
            
            echo '<li class="ui-state-default list-list-item">';
              alchem_list_item_view( $field_id, $key, $list_item, $post_id, $get_option, $field_settings, $type );
            echo '</li>';
            
          }
          
        }
        
        echo '</ul>';
        
        /* button */
        echo '<a href="javascript:void(0);" class="option-tree-list-item-add option-tree-ui-button button button-primary right hug-right" title="' . __( 'Add New', 'alchem' ) . '">' . __( 'Add New', 'alchem' ) . '</a>';
        
        /* description */
        echo '<div class="list-item-description">' . __( 'You can re-order with drag & drop, the order will update after saving.', 'alchem' ) . '</div>';
      
      echo '</div>';

    echo '</div>';
    
  }
  
}

/**
 * Post Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_post_checkbox' ) ) {
  
  function alchem_type_post_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'alchem_type_post_checkbox_query', array( 'post_type' => array( 'post' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<p>';
            echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $my_post->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '" value="' . esc_attr( $my_post->ID ) . '" ' . ( isset( $field_value[$my_post->ID] ) ? checked( $field_value[$my_post->ID], $my_post->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
            echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $my_post->ID ) . '">' . $post_title . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . __( 'No Posts Found', 'alchem' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Post Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_post_select' ) ) {
  
  function alchem_type_post_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-post-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* query posts array */
        $my_posts = get_posts( apply_filters( 'alchem_type_post_select_query', array( 'post_type' => array( 'post' ), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post_status' => 'any' ), $field_id ) );
        
        /* has posts */
        if ( is_array( $my_posts ) && ! empty( $my_posts ) ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach( $my_posts as $my_post ) {
            $post_title = '' != $my_post->post_title ? $my_post->post_title : 'Untitled';
            echo '<option value="' . esc_attr( $my_post->ID ) . '"' . selected( $field_value, $my_post->ID, false ) . '>' . $post_title . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Posts Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Radio option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_radio' ) ) {
  
  function alchem_type_radio( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build radio */
        foreach ( (array) $field_choices as $key => $choice ) {
          echo '<p><input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="radio option-tree-ui-radio ' . esc_attr( $field_class ) . '" /><label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label></p>';
        }
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Radio Images option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_radio_image' ) ) {
  
  function alchem_type_radio_image( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-radio-image ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /**
         * load the default filterable images if nothing 
         * has been set in the choices array.
         */
        if ( empty( $field_choices ) )
          $field_choices = alchem_radio_images( $field_id );
          
        /* build radio image */
        foreach ( (array) $field_choices as $key => $choice ) {
          
          $src = str_replace( 'ALCHEM_THEME_URI', ALCHEM_THEME_URI, $choice['src'] );
       //   $src = str_replace( 'alchem_THEME_URL', alchem_THEME_URL, $src );
          
          /* make radio image source filterable */
          $src = apply_filters( 'alchem_type_radio_image_src', $src, $field_id );
          
          echo '<div class="option-tree-ui-radio-images">';
            echo '<p style="display:none"><input type="radio" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '" value="' . esc_attr( $choice['value'] ) . '"' . checked( $field_value, $choice['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label for="' . esc_attr( $field_id ) . '-' . esc_attr( $key ) . '">' . esc_attr( $choice['label'] ) . '</label></p>';
            echo '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $choice['label'] ) .'" title="' . esc_attr( $choice['label'] ) .'" class="option-tree-ui-radio-image ' . esc_attr( $field_class ) . ( $field_value == $choice['value'] ? ' option-tree-ui-radio-image-selected' : '' ) . '" />';
          echo '</div>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_select' ) ) {
  
  function alchem_type_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
        foreach ( (array) $field_choices as $choice ) {
          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $field_value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
          }
        }
        
        echo '</select>';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Sidebar Select option type.
 *
 * This option type makes it possible for users to select a WordPress registered sidebar 
 * to use on a specific area. By using the two provided filters, 'alchem_recognized_sidebars', 
 * and 'alchem_recognized_sidebars_{$field_id}' we can be selective about which sidebars are 
 * available on a specific content area.
 *
 * For example, if we create a WordPress theme that provides the ability to change the 
 * Blog Sidebar and we don't want to have the footer sidebars available on this area, 
 * we can unset those sidebars either manually or by using a regular expression if we 
 * have a common name like footer-sidebar-$i.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.1
 */
if ( ! function_exists( 'alchem_type_sidebar_select' ) ) {
  
  function alchem_type_sidebar_select( $args = array() ) {
  
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-sidebar-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build page select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';

        /* get the registered sidebars */
        global $wp_registered_sidebars;

        $alchem_sidebars = array();
        foreach( $wp_registered_sidebars as $id=>$sidebar ) {
          $alchem_sidebars[ $id ] = $sidebar[ 'name' ];
        }

        /* filters to restrict which sidebars are allowed to be selected, for example we can restrict footer sidebars to be selectable on a blog page */
        $alchem_sidebars = apply_filters( 'alchem_recognized_sidebars', $alchem_sidebars );
        $alchem_sidebars = apply_filters( 'alchem_recognized_sidebars_' . $field_id, $alchem_sidebars );

        /* has sidebars */
        if ( count( $alchem_sidebars ) ) {
          echo '<option value="">-- ' . __( 'Choose Sidebar', 'alchem' ) . ' --</option>';
          foreach ( $alchem_sidebars as $id => $sidebar ) {
            echo '<option value="' . esc_attr( $id ) . '"' . selected( $field_value, $id, false ) . '>' . esc_attr( $sidebar ) . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Sidebars', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Tab option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.3.0
 */
if ( ! function_exists( 'alchem_type_tab' ) ) {
  
  function alchem_type_tab( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tab">';

      echo '<br />';
    
    echo '</div>';
    
  }
  
}

/**
 * Tag Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_tag_checkbox' ) ) {
  
  function alchem_type_tag_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* get tags */
        $tags = get_tags( array( 'hide_empty' => false ) );
        
        /* has tags */
        if ( $tags ) {
          foreach( $tags as $tag ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $tag->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $tag->term_id ) . '" value="' . esc_attr( $tag->term_id ) . '" ' . ( isset( $field_value[$tag->term_id] ) ? checked( $field_value[$tag->term_id], $tag->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $tag->term_id ) . '">' . esc_attr( $tag->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . __( 'No Tags Found', 'alchem' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Tag Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_tag_select' ) ) {
  
  function alchem_type_tag_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build tag select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* get tags */
        $tags = get_tags( array( 'hide_empty' => false ) );
        
        /* has tags */
        if ( $tags ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach( $tags as $tag ) {
            echo '<option value="' . esc_attr( $tag->term_id ) . '"' . selected( $field_value, $tag->term_id, false ) . '>' . esc_attr( $tag->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Tags Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Taxonomy Checkbox option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_taxonomy_checkbox' ) ) {
  
  function alchem_type_taxonomy_checkbox( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-taxonomy-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* setup the taxonomy */
        $taxonomy = isset( $field_taxonomy ) ? explode( ',', $field_taxonomy ) : array( 'category' );
        
        /* get taxonomies */
        $taxonomies = get_categories( apply_filters( 'alchem_type_taxonomy_checkbox_query', array( 'hide_empty' => false, 'taxonomy' => $taxonomy ), $field_id ) );
        
        /* has tags */
        if ( $taxonomies ) {
          foreach( $taxonomies as $taxonomy ) {
            echo '<p>';
              echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $taxonomy->term_id ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $taxonomy->term_id ) . '" value="' . esc_attr( $taxonomy->term_id ) . '" ' . ( isset( $field_value[$taxonomy->term_id] ) ? checked( $field_value[$taxonomy->term_id], $taxonomy->term_id, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
              echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $taxonomy->term_id ) . '">' . esc_attr( $taxonomy->name ) . '</label>';
            echo '</p>';
          } 
        } else {
          echo '<p>' . __( 'No Taxonomies Found', 'alchem' ) . '</p>';
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Taxonomy Select option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_taxonomy_select' ) ) {
  
  function alchem_type_taxonomy_select( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-tag-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build tag select */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* setup the taxonomy */
        $taxonomy = isset( $field_taxonomy ) ? explode( ',', $field_taxonomy ) : array( 'category' );
        
        /* get taxonomies */
        $taxonomies = get_categories( apply_filters( 'alchem_type_taxonomy_select_query', array( 'hide_empty' => false, 'taxonomy' => $taxonomy ), $field_id ) );
        
        /* has tags */
        if ( $taxonomies ) {
          echo '<option value="">-- ' . __( 'Choose One', 'alchem' ) . ' --</option>';
          foreach( $taxonomies as $taxonomy ) {
            echo '<option value="' . esc_attr( $taxonomy->term_id ) . '"' . selected( $field_value, $taxonomy->term_id, false ) . '>' . esc_attr( $taxonomy->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Taxonomies Found', 'alchem' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Text option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_text' ) ) {
  
  function alchem_type_text( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-text ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build text input */
        echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Textarea option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_textarea' ) ) {
  
  function alchem_type_textarea( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . ' fill-area">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build textarea */
        wp_editor( 
          $field_value, 
          esc_attr( $field_id ), 
          array(
            'editor_class'  => esc_attr( $field_class ),
            'wpautop'       => apply_filters( 'alchem_wpautop', false, $field_id ),
            'media_buttons' => apply_filters( 'alchem_media_buttons', true, $field_id ),
            'textarea_name' => esc_attr( $field_name ),
            'textarea_rows' => esc_attr( $field_rows ),
            'tinymce'       => apply_filters( 'alchem_tinymce', true, $field_id ),              
            'quicktags'     => apply_filters( 'alchem_quicktags', array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ), $field_id )
          ) 
        );
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Textarea Simple option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_textarea_simple' ) ) {
  
  function alchem_type_textarea_simple( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textarea simple ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
        
        /* filter to allow wpautop */
        $wpautop = apply_filters( 'alchem_wpautop', false, $field_id );
        
        /* wpautop $field_value */
        if ( $wpautop == true ) 
          $field_value = wpautop( $field_value );
        
        /* build textarea simple */
        echo '<textarea class="textarea ' . esc_attr( $field_class ) . '" rows="' . esc_attr( $field_rows )  . '" cols="40" name="' . esc_attr( $field_name ) .'" id="' . esc_attr( $field_id ) . '">' . esc_textarea( $field_value ) . '</textarea>';
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Textblock option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_textblock' ) ) {
  
  function alchem_type_textblock( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textblock wide-desc">';
      
      /* description */
      echo '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Textblock Titled option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_textblock_titled' ) ) {
  
  function alchem_type_textblock_titled( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-textblock titled wide-desc">';
      
      /* description */
      echo '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Typography option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_typography' ) ) {
  
  function alchem_type_typography( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-typography ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">'; 
        
        /* allow fields to be filtered */
        $alchem_recognized_typography_fields = apply_filters( 'alchem_recognized_typography_fields', array( 
          'font-color',
          'font-family', 
          'font-size', 
          'font-style', 
          'font-variant', 
          'font-weight', 
          'letter-spacing', 
          'line-height', 
          'text-decoration', 
          'text-transform' 
        ), $field_id );
        
        /* build font color */
        if ( in_array( 'font-color', $alchem_recognized_typography_fields ) ) {
          
          /* build colorpicker */  
          echo '<div class="option-tree-ui-colorpicker-input-wrap">';
            
            /* colorpicker JS */      
            echo '<script>jQuery(document).ready(function($) { ALCHEM_UI.bind_colorpicker("' . esc_attr( $field_id ) . '-picker"); });</script>';
            
            /* set background color */
            $background_color = isset( $field_value['font-color'] ) ? esc_attr( $field_value['font-color'] ) : '';
            
            /* input */
            echo '<input type="text" name="' . esc_attr( $field_name ) . '[font-color]" id="' . esc_attr( $field_id ) . '-picker" value="' . esc_attr( $background_color ) . '" class="hide-color-picker ' . esc_attr( $field_class ) . '" />';
          
          echo '</div>';
        
        }
        
        /* build font family */
        if ( in_array( 'font-family', $alchem_recognized_typography_fields ) ) {
          $font_family = isset( $field_value['font-family'] ) ? $field_value['font-family'] : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-family]" id="' . esc_attr( $field_id ) . '-font-family" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-family</option>';
            foreach ( alchem_recognized_font_families( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_family, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font size */
        if ( in_array( 'font-size', $alchem_recognized_typography_fields ) ) {
          $font_size = isset( $field_value['font-size'] ) ? esc_attr( $field_value['font-size'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-size]" id="' . esc_attr( $field_id ) . '-font-size" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-size</option>';
            foreach( alchem_recognized_font_sizes( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $font_size, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font style */
        if ( in_array( 'font-style', $alchem_recognized_typography_fields ) ) {
          $font_style = isset( $field_value['font-style'] ) ? esc_attr( $field_value['font-style'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-style]" id="' . esc_attr( $field_id ) . '-font-style" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-style</option>';
            foreach ( alchem_recognized_font_styles( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_style, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font variant */
        if ( in_array( 'font-variant', $alchem_recognized_typography_fields ) ) {
          $font_variant = isset( $field_value['font-variant'] ) ? esc_attr( $field_value['font-variant'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-variant]" id="' . esc_attr( $field_id ) . '-font-variant" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-variant</option>';
            foreach ( alchem_recognized_font_variants( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_variant, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build font weight */
        if ( in_array( 'font-weight', $alchem_recognized_typography_fields ) ) {
          $font_weight = isset( $field_value['font-weight'] ) ? esc_attr( $field_value['font-weight'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[font-weight]" id="' . esc_attr( $field_id ) . '-font-weight" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">font-weight</option>';
            foreach ( alchem_recognized_font_weights( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_weight, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build letter spacing */
        if ( in_array( 'letter-spacing', $alchem_recognized_typography_fields ) ) {
          $letter_spacing = isset( $field_value['letter-spacing'] ) ? esc_attr( $field_value['letter-spacing'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[letter-spacing]" id="' . esc_attr( $field_id ) . '-letter-spacing" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">letter-spacing</option>';
            foreach( alchem_recognized_letter_spacing( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $letter_spacing, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build line height */
        if ( in_array( 'line-height', $alchem_recognized_typography_fields ) ) {
          $line_height = isset( $field_value['line-height'] ) ? esc_attr( $field_value['line-height'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[line-height]" id="' . esc_attr( $field_id ) . '-line-height" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">line-height</option>';
            foreach( alchem_recognized_line_heights( $field_id ) as $option ) { 
              echo '<option value="' . esc_attr( $option ) . '" ' . selected( $line_height, $option, false ) . '>' . esc_attr( $option ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text decoration */
        if ( in_array( 'text-decoration', $alchem_recognized_typography_fields ) ) {
          $text_decoration = isset( $field_value['text-decoration'] ) ? esc_attr( $field_value['text-decoration'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-decoration]" id="' . esc_attr( $field_id ) . '-text-decoration" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-decoration</option>';
            foreach ( alchem_recognized_text_decorations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_decoration, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
        /* build text transform */
        if ( in_array( 'text-transform', $alchem_recognized_typography_fields ) ) {
          $text_transform = isset( $field_value['text-transform'] ) ? esc_attr( $field_value['text-transform'] ) : '';
          echo '<select name="' . esc_attr( $field_name ) . '[text-transform]" id="' . esc_attr( $field_id ) . '-text-transform" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
            echo '<option value="">text-transform</option>';
            foreach ( alchem_recognized_text_transformations( $field_id ) as $key => $value ) {
              echo '<option value="' . esc_attr( $key ) . '" ' . selected( $text_transform, $key, false ) . '>' . esc_attr( $value ) . '</option>';
            }
          echo '</select>';
        }
        
      echo '</div>';
      
    echo '</div>';
    
  }
  
}

/**
 * Upload option type.
 *
 * See @alchem_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'alchem_type_upload' ) ) {
  
  function alchem_type_upload( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-upload ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build upload */
        echo '<div class="option-tree-ui-upload-parent">';
          
          /* input */
          echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-upload-input ' . esc_attr( $field_class ) . '" />';
          
          /* add media button */
          echo '<a href="javascript:void(0);" class="alchem_upload_media option-tree-ui-button button button-primary light" rel="' . $post_id . '" title="' . __( 'Add Media', 'alchem' ) . '"><span class="icon alchem-icon-plus-sign"></span>' . __( 'Add Media', 'alchem' ) . '</a>';
        
        echo '</div>';
        
        /* media */
        if ( $field_value ) {
        
          echo '<div class="option-tree-ui-media-wrap" id="' . esc_attr( $field_id ) . '_media">';
          
            if ( preg_match( '/\.(?:jpe?g|png|gif|ico)$/i', $field_value ) )
              echo '<div class="option-tree-ui-image-wrap"><img src="' . esc_url( $field_value ) . '" alt="" /></div>';
            
            echo '<a href="javascript:(void);" class="option-tree-ui-remove-media option-tree-ui-button button button-secondary light" title="' . __( 'Remove Media', 'alchem' ) . '"><span class="icon alchem-icon-minus-sign"></span>' . __( 'Remove Media', 'alchem' ) . '</a>';
            
          echo '</div>';
          
        }
        
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/* End of file alchem-functions-option-types.php */
/* Location: ./includes/alchem-functions-option-types.php */