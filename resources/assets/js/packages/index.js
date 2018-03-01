import Vue from 'vue'
import QuillEditor from 'vue-quill-editor'

import fontawesome from '@fortawesome/fontawesome'

// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(QuillEditor, /* { default global options } */)