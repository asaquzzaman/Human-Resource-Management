<template>
	<div>
	    <?php
	    $query_args = hrm_get_query_args();
	    $page       = $query_args['page'];
	    $tab        = $query_args['tab'];
	    $subtab     = $query_args['subtab'];
	    $menu = hrm_page();
	    ?>
	    <h2 class="nav-tab-wrapper">
	        <?php

	        foreach ( $menu[$page] as $key => $tab_event ) {
	            if ( isset( $tab_event['nested_tab'] ) && $tab_event['nested_tab'] === true ) {
	                continue;
	            }

	            $active = ( $tab == $key ) ? 'nav-tab-active' : '';
	            $url = empty( $tab_event['url'] ) ? '/' : $tab_event['url'];
	            
	            printf( '<router-link class="nav-tab" to="%s">%s</router-link>', $url, $tab_event['title'] );
	        }

	        ?>
	    </h2>
	    <?php
	    if ( ! $subtab ) {
	       if( !isset( $menu[$page][$tab]['submenu'] ) ) {
	            echo '</div>';
	            return;
	        }

	        if ( !count( $menu[$page][$tab]['submenu'] ) ) {
	            return;
	        }

	        $subtab = key( $menu[$page][$tab]['submenu'] );
	    }

	    if ( ! $subtab ) {
	        return;
	    }

	    ?>
	    <h3 class="hrm-sub-nav">
	        <ul class="hrm-subsubsub">
	            <?php
	                foreach ( $menu[$page][$tab]['submenu'] as $sub_key => $sub_event ) {
	                    $sub_active = ( $sub_key == $subtab ) ? 'hrm-sub-current' : '';
	                    $sub_event['id'] = isset( $sub_event['id'] ) ? $sub_event['id'] : '';
	                    $sub_url = hrm_subtab_menu_url( $tab, $sub_key, $page );
	                    printf( '<li><a class="%4$s" href="%1$s" id="%2$s-tab">%3$s</a></li> | ',$sub_url , $sub_event['id'], $sub_event['title'], $sub_active );
	                }
	            ?>
	        </ul>
	    </h3>
	</div>

</template>

<script>
	export default {
		store: HRM_Attendance_Store,
		mixins: [HRM_Common_Mixin],
		data: function() {
			return {
				
			}
		},
		created: function() {
			
		},
		methods: {

		}
	}
</script>

<!-- var hrm_attendance_header = {
	template: '#tmpl-hrm-attendance-header',
	store: HRM_Attendance_Store,
	mixins: [HRM_Common_Mixin],
	data: function() {
		return {
			
		}
	},
	created: function() {
		
	},
	methods: {

	}
}; -->