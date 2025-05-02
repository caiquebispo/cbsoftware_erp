import axios from 'axios';
window.axios = axios;

import moment from "moment";
window.moment = moment;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
