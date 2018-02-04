import DoAction from '@components/common/do-action.vue';
import SettingsHeader from '@components/settings/header.vue';
import DatePicker from '@components/common/date-picker.vue';
import FormFields from '@components/common/form-fields.vue';
import Pagination from '@components/common/pagination.vue';
import HRMUploader from '@components/common/file-uploader.vue';
import EditFields from '@components/common/edit-fields.vue';



hrm.Vue.component('hrm-do-action', DoAction);
hrm.Vue.component('hrm-settings-header', SettingsHeader);
hrm.Vue.component('hrm-date-picker', DatePicker);
hrm.Vue.component('hrm-form-fields', FormFields);
hrm.Vue.component('hrm-pagination', Pagination);
hrm.Vue.component('hrm-file-uploader', HRMUploader);
hrm.Vue.component('hrm-edit-field', EditFields);
