import Vue from '@vue/vue';
import DoAction from '@components/common/do-action.vue';
import SettingsHeader from '@components/settings/header.vue';
import Multiselect from './../../vue-multiselect/vue-multiselect.min';

hrm.Multiselect = Multiselect;

Vue.component('hrm-do-action', DoAction);
Vue.component('hrm-settings-header', SettingsHeader);