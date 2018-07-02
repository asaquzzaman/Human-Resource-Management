<template>
    <textarea :id="editor_id" v-model="value"></textarea>
</template>

<script>
    export default {
        
        // watch: {
        //     value(old) {
        //         if (old ) {  
        //             tinymce.get(this.editor_id).setContent(old);
        //             tinymce.get(this.editor_id).save();
        //         }
        //     }
        // },

        // Get passing data for this component.
        props: ['editor_id', 'value'],

        // Initial action for this component
        mounted: function() {
            var self = this;

            if(tinymce.get(this.editor_id)) {
                tinymce.execCommand( 'mceRemoveEditor', false, this.editor_id );
            }
           
            
            // Instantiate the editor
            var settings = {
                selector: 'textarea#' + self.editor_id,
                menubar: false,
                // placeholder: 'Write a comment...',
                branding: false,
                menubar: false,
                setup: function (editor) {
                    editor.on('change', function () {
                        self.$emit('input', editor.getContent());
                    });
                    editor.on('keyup', function (event) {
                        self.$emit('input', editor.getContent());
                    });
                    editor.on('NodeChange', function () {
                        self.$emit('input', editor.getContent());
                    });
                },

                // external_plugins: {
                //     'placeholder': PM_Vars.assets_url + 'vendor/tinymce/plugins/placeholder/plugin.min.js',
                // },

                fontsize_formats: '10px 11px 13px 14px 16px 18px 22px 25px 30px 36px 40px 45px 50px 60px 65px 70px 75px 80px',
                font_formats : 'Arial=arial,helvetica,sans-serif;'+
                    'Comic Sans MS=comic sans ms,sans-serif;'+
                    'Courier New=courier new,courier;'+
                    'Georgia=georgia,palatino;'+
                    'Lucida=Lucida Sans Unicode, Lucida Grande, sans-serif;'+
                    'Tahoma=tahoma,arial,helvetica,sans-serif;'+
                    'Times New Roman=times new roman,times;'+
                    'Trebuchet MS=trebuchet ms,geneva;'+
                    'Verdana=verdana,geneva;',
                plugins: 'textcolor colorpicker wplink wordpress',
                toolbar1: 'shortcodes bold italic strikethrough bullist numlist alignleft aligncenter alignjustify alignright link wp_adv',
                toolbar2: 'formatselect forecolor backcolor underline blockquote hr code',
                toolbar3: 'fontselect fontsizeselect removeformat undo redo',
            };

            if (self.tinyMCE_settings) {
                settings = jQuery.extend(settings, self.tinyMCE_settings);
            }

            tinymce.init(settings);
        },
    }
</script>





