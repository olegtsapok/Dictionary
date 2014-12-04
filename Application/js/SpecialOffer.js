
SpecialOffer = {
    newImagesCount: 0,
    addImage: function(obj) 
    {
        $(obj).prev().addClass('loading');
        
        self = this;
        self.newImagesCount++;
        index = "new_" + self.newImagesCount;
        
        params = {'index':index};
        $.ajax({
           url: 'index.php?r=SpecialOffer/getTemplateImage',
           data: params,
           success: function(data) { 
                $(obj).prev().removeClass('loading');
                $(obj).parent().before(data);
           },            
       }); 
        return false;  
    },

    delImage: function(obj, index) 
    {
        $(obj).parent().after('<input type="hidden" name="SpecialOffer-delete_images[]" value="'+index+'">');
        $(obj).parent().remove();
        return false;  
    },
    
}