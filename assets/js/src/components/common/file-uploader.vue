<template>
    <div class="hrm-attachment-area">
        <div v-hrm-uploader id="hrm-upload-container">
            <div class="hrm-upload-filelist">
                <div class="hrm-uploaded-item" v-for="file in files" :key="file.id">
                    <a class="hrm-uploaded-img" :href="file.url" target="_blank">
                        <img :style="'height:'+attr.height+'; width:'+attr.width+';'" class="hrm-uploaded-file" :src="file.thumb" :alt="file.name">
                    </a> 
                    
                    <a href="#"  @click.prevent="deletefile(file.id)" class="button">Delete</a>
                        
                </div>
     
                           
            </div>
            <span>To attach, <a id="hrm-upload-pickfiles"  href="#">select files</a> from your computer.</span>
        </div>
    </div>
</template>



<script>
    // Register a global custom directive called v-hrm-popup-box
    hrm.Vue.directive('hrm-uploader', {
        inserted: function (el, binding, vnode) { 
            new HRM_Uploader('hrm-upload-pickfiles', 'hrm-upload-container', vnode.context );
        },

        update: function (el, binding, vnode) { 
            new HRM_Uploader('hrm-upload-pickfiles', 'hrm-upload-container', vnode.context );
        }
    });

    export default {
        props: {
            files: {
                type: [Array],
                default () {
                    return [];
                }
            },
            delete: {
                type: [Array],
                default () {
                    return [];
                }
            },
            multiple: {
                type: [Boolean],
                defalut () {
                    return false
                }
            },

            attr: {
                type: [Object],
                default () {
                    return {
                        height: '80px',
                        width: '80px'
                    }
                }
            }
        },


        methods: {
            /**
             * Set the uploaded file
             *
             * @param  object file_res
             *
             * @return void
             */
            fileUploaded: function( file_res ) {

                if ( typeof this.files == 'undefined' ) {
                    this.files = [];
                }
                
                this.files.push( file_res.res.file );
                
            },

            /**
             * Delete file
             *
             * @param  object file_id
             *
             * @return void
             */
            deletefile: function(file_id) {
                if ( ! confirm( 'Are you suer!' ) ) {
                    return;
                }
                var self = this;
                var index = self.getIndex(self.files, file_id, 'id');

                if (index !== false) {
                    self.files.splice(index, 1);
                    this.delete.push(file_id);
                }  
            },
            test () {

            }
        }
    }
</script>