var question = {
    mandatory : 0,
    maxlength : 255,
    content : '',
    texttype : function () {
        this.content = '<input type="text" name="question" max-length=""/>';
        this.content += '<br />';
        this.content += '<input type="checkbox" name="mandatory" value="1" checked />Mandatory';
        this.content += '<br />';
   }
};