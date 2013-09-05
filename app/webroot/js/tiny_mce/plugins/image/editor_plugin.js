(function(){
    tinymce.create('tinymce.plugins.image',{

        init : function(ed, url){

            ed.addCommand('open_image',function(){
                ed.windowManager.open({
                    file : ed.settings.image_explorer,
                    id : 'image',
                    width : 1000,
                    height : 600,
                    inline : true,
                    title : 'Insérer une Image'
                },{
                    plugin_url : url
                });
            });

            ed.addButton('image',{
                title   : 'Insérer une Image',
                cmd     : 'open_image'
            });

        }
    });
    tinymce.PluginManager.add('image',tinymce.plugins.image);
})();