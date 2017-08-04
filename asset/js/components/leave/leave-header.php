<div>
    <h2 class="nav-tab-wrapper">
        <router-link v-for="head in header" class="nav-tab" :to="head.url">{{ head.title }}</router-link>
    </h2>

    <h3 class="hrm-sub-nav" v-if="has_child_menu() || is_it_child()">
        <ul class="hrm-subsubsub">

            <li v-for="child_menu in get_child_menu()">
                <router-link  :to="{name: child_menu.name}">{{ child_menu.title }}</router-link> |&nbsp;
            </li> 
          
        </ul>
    </h3>

</div>
