import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import _ from 'lodash';
window._ = _

import './nice-admin/vendor/bootstrap/css/bootstrap.min.css'
import './nice-admin/vendor/bootstrap-icons/bootstrap-icons.css'
import './nice-admin/vendor/boxicons/css/boxicons.min.css'
import './nice-admin/vendor/quill/quill.snow.css'
import './nice-admin/vendor/quill/quill.bubble.css'
import './nice-admin/vendor/remixicon/remixicon.css'
import './nice-admin/vendor/simple-datatables/style.css'

import './nice-admin/css/style.css'

import './nice-admin/vendor/apexcharts/apexcharts.min'
import './nice-admin/vendor/bootstrap/js/bootstrap.bundle.min'
import './nice-admin/vendor/chart.js/chart.umd'
import './nice-admin/vendor/echarts/echarts.simple.min'
import './nice-admin/vendor/quill/quill'
import './nice-admin/vendor/simple-datatables/simple-datatables'
import './nice-admin/vendor/tinymce/tinymce.min'
import './nice-admin/vendor/php-email-form/validate'

import './nice-admin/js/main'



