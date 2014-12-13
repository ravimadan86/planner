// custom javascript file
$(function(){
/******* JS Code for Notifications controller*******/

    /**
     * function is called when send email button is clicked
     * performs ajax operation to send email
     */
    $("#sendEmail").on("click", function(){
        // fetching the selected users
        // fetching the from field value
        var NotificationTemplates_from = $("#NotificationTemplates_from").val();
        //fetching Mailgroup to be send
        var NotificationTemplates_mailgroup = $("#NotificationTemplates_mailgroup").val();
        // fetching Senders Name
        var NotificationTemplates_senders_name = $("#NotificationTemplates_senders_name").val();
        // fetching the subject field value
        var NotificationTemplates_subject = $("#NotificationTemplates_subject").val();
        // fetching the content of email
        var notificationContent = tinyMCE.get('notificationContent').getContent();

        // @var array will contain the array of error if exists
        var errors = [];
        if ( NotificationTemplates_from == '' )
        {
            errors.push("- From field can not be blank\r\n");
        }
        if ( NotificationTemplates_mailgroup == '' )
        {
            errors.push("- Select Mailgroup to send mail\r\n");
        }
        if ( NotificationTemplates_senders_name == '' )
        {
            errors.push("- Senders name field can not be blank\r\n");
        }
        if ( NotificationTemplates_subject == '' )
        {
            errors.push("- Subject field can not be blank\r\n");
        }
        if ( notificationContent == '' )
        {
            errors.push("- Body field can not be blank\r\n");
        }
        // if errors exists then return false
        if ( errors.length > 0 )
        {
            alert("Please fix following errors :-\r\n" + errors.join(""));
        }
        // if no errors then perform the ajax function
        else
        {
            var serializedForm = $("#notification-form").serializeArray();
            loadingMessage('show');
            $.ajax({
                url: Yii.urls.sendEmailUrl,
                cache: false,
                type: "POST",
                dataType: "JSON",
                data: serializedForm,
                success: function(data){
                    if (data.success == "1")
                    {
                        alert(data.message);
                    }
                    else
                    {
                        alert(data.message);
                    }
                    loadingMessage('hide');
                },
                error: function(){
                    alert("Email sending failed");
                    loadingMessage('hide');
                }
            });
        }
    });

    /**
     * function is performed when the template is changed from the dropdown
     */
    $("#notification-form #NotificationTemplates_id").on("change", function(){
        // fetching the template id from select menu
        var templateId = $(this).val();
        
        // JSON object to contain html ID attrbutes of form fields
        var formFields = {
            'from' : 'NotificationTemplates_from',
            'sendersName' : 'NotificationTemplates_senders_name',
            'subject' : 'NotificationTemplates_subject',
            'content' : 'notificationContent',
            'title' : 'NotificationTemplates_title',
            'type' : 'NotificationTemplates_type'
        };
        // calling the load template function
        loadTemplate(templateId, formFields);
    });
    
    /**
     * function is performed when the template is changed from the dropdown
     */
    $("#NotificationTemplates_mailgroup").on("change", function(){
        // fetching the template id from select menu
        var mailgroup_id = $(this).val();
        
        loadingMessage('show');
        $.ajax({
            url: Yii.urls.loadMailgroupTagsUrl,
            cache: false,
            type: "POST",
            dataType: "JSON",
            data: { 'mailgroup_id' : mailgroup_id },
            success: function(data){
                if (data.success == "1")
                {
                    $('#custom_field_tags').css('color','red');
                    $('#custom_field_tags').html('You can use following dynamic tags while working with template :-');
                    $('#custom_field_tags').append('<br />' + data.message.join('<br />'));
                }
                else if (data.success == "0")
                {
                    $('#custom_field_tags').html("");
                }
                
                loadingMessage('hide');
            },
            error: function(){
                alert('Action cannot be completed');
                loadingMessage('hide');
            }
        });
        
    });
    /*
     * function is called when save template button is clicked
     * performs ajax operation to save template
     */
    $("#saveTemplate").on("click", function(){
        var NotificationTemplates_id = $("#NotificationTemplates_id").val();
        if (NotificationTemplates_id == '')
        {
            alert("Please select template to update");
            return false;
        }
        var NotificationTemplates_from = $("#NotificationTemplates_from").val();
        var NotificationTemplates_type = $("#NotificationTemplates_type").val();
        var NotificationTemplates_subject = $("#NotificationTemplates_subject").val();
        var notificationContent = ( NotificationTemplates_type =='email' ) ? tinyMCE.get('notificationContent').getContent() : $("#notificationContent").val();
        var NotificationTemplates_title = $("#NotificationTemplates_title").val();
        var errors = [];
        if ( NotificationTemplates_from == '' )
        {
            errors.push("- Template from can not be blank\r\n");
        }
        if ( NotificationTemplates_subject == '' )
        {
            errors.push("- Template subject can not be blank\r\n");
        }
        if ( notificationContent == '' )
        {
            errors.push("- Template body can not be blank\r\n");
        }
        if ( NotificationTemplates_title == '' )
        {
            errors.push("- Template title can not be blank\r\n");
        }
        // if form contains empty fields
        if ( errors.length > 0 )
        {
            alert("Please fix following errors :-\r\n" + errors.join(""));
        }
        // perform save template action if validation is successful
        else
        {
            var serializedForm = $("#notification-form").serializeArray();
            loadingMessage('show');
            $.ajax({
                url: Yii.urls.saveTemplateUrl,
                cache: false,
                type: "POST",
                dataType: "JSON",
                data: serializedForm,
                success: function(data){
                    if (data.success == "1")
                    {
                        if (data.isNewTemplate == 1)
                        {
                            $("#NotificationTemplates_id").prepend($("<option/>",{
                                'value' : data.id,
                                'text' : data.title,
                                'selected' : 'selected'
                            }));
                        }
                    }
                    alert(data.message);
                    loadingMessage('hide');
                },
                error: function(){
                    loadingMessage('hide');
                }
            });
        }
    });

    /**
     * function is called when delete template button is clicked
     */
    $("#deleteTemplate").on("click",function(){
        var formFields = {
            'id' : 'NotificationTemplates_id',
            'sendersName' : 'NotificationTemplates_senders_name',
            'from' : 'NotificationTemplates_from',
            'subject' : 'NotificationTemplates_subject',
            'content' : 'notificationContent',
            'title' : 'NotificationTemplates_title',
            'type' : 'NotificationTemplates_type'
        };
        var templateId = $("#notification-form #NotificationTemplates_id").val();
        clearTemplate(formFields);
        if (templateId != 'new')
        {
            deleteTemplate(templateId, formFields);
        }
    });

    /**
     * function is called when send sms button is clicked
     * performs ajax operation to send sms
     */
    $("#sendSms").on("click", function(){
        // fetching the selected users
        var selectedUserIds = $("#user-grid").selGridView("getAllSelection");
        var sendAll = $('#sendAll').is(":checked");                
        // if atleast 1 user is selected
        if ( selectedUserIds.length > 0 || sendAll)
        {
            // fetching the content of email
            var notificationContent = $('#notificationContent').val();

            // @var array will contain the array of error if exists
            var errors = [];
            if ( notificationContent == '' )
            {
                errors.push("- Body field can not be blank\r\n");
            }
            // if errors exists then return false
            if ( errors.length > 0 )
            {
                alert("Please fix following errors :-\r\n" + errors.join(""));
            }
            // if no errors then perform the ajax function
            else
            {
                var serializedForm = $("#notification-form").serializeArray();
                serializedForm.push({name : "userIds", value : selectedUserIds});
                serializedForm.push({name : "sendAll", value : sendAll});                
                loadingMessage('show');
                $.ajax({
                    url: Yii.urls.sendSmsUrl,
                    cache: false,
                    type: "POST",
                    dataType: "JSON",
                    data: serializedForm,
                    success: function(data){
                        if (data.success == "1")
                        {
                            alert(data.message);
                        }
                        else
                        {
                            alert(data.message);
                        }
                        loadingMessage('hide');
                    },
                    error: function(){
                        alert("SMS sending failed");
                        loadingMessage('hide');
                    }
                });
            }
        }
        // if no user is selected
        else
        {
            alert("Please select atleast one user to whom you want to send notification");
        }
    });

    
});

/**
 * function loads templated by ajax request
 */
function loadTemplate(id, formFields)
{
    if (id == 'new' || id == '')
    {
        clearTemplate(formFields);
    }
    else
    {
        loadingMessage('show');
        $.ajax({
            url: Yii.urls.loadTemplateUrl,
            cache: false,
            type: "POST",
            dataType: "JSON",
            data: {
                'id' : id
            },
            success: function(data){
                if (data.success == "1")
                {
                    populateTemplate(formFields, data);
                }
                else
                {
                    alert(data.message);
                }
                loadingMessage('hide');
            },
            error: function(data) {
                loadingMessage('hide');
            }
        });
    }
}
/**
 * function clears the template form
 */
function clearTemplate(formFields)
{
    // fetching the template type
    var type = $("#" + formFields.type).val();
    
    if ( type == 'email' )
    {
        $("#" + formFields.from).val("");
        $("#" + formFields.sendersName).val("");
        $("#" + formFields.subject).val("");
    }
    /*if ( type != 'email' )
    {
        $("#" + formFields.subject).val("-");
    }*/
    $("#" + formFields.title).val("");
    if ( formFields.contentType == 'tinyMCE' )
    {
        tinyMCE.get(formFields.content).setContent("");
    }
    else
    {
        $("#" + formFields.content).val("");
    }
}

/**
 * function fills the template values to the template form
 */
function populateTemplate(formFields, data)
{
    var type = $("#" + formFields.type).val();
    if ( type == 'email' )
    {
        $("#" + formFields.from).val(data.from);
        $("#" + formFields.sendersName).val(data.sendersName);
        tinyMCE.get(formFields.content).setContent(data.content);
    }
    else
    {
        $("#" + formFields.content).val(data.content);
    }
    $("#" + formFields.subject).val(data.subject);
    $("#" + formFields.title).val(data.title);
}

/**
 * function deletes the template by ajax request
 */
function deleteTemplate(id, formFields)
{
    var selectMenuId = formFields.id;
    loadingMessage('show');
    $.ajax({
        url: Yii.urls.deleteTemplateUrl,
        cache: false,
        type: "POST",
        dataType: "JSON",
        data: {
            'id' : id
        },
        success: function(data){
            if (data.success == "1")
            {
                removeTemplateFromOptions(id, selectMenuId);
            }
            else
            {
                alert(data.message);
            }
            loadingMessage('hide');
        },
        error: function(){
            loadingMessage('hide');
        }
    });
}

/**
 * function removes template from the select menu options
 */
function removeTemplateFromOptions(id, selectMenuId)
{
    $("#" + selectMenuId + " option").each(function(){
        if ( $(this).prop('value') == id )
        {
            $(this).remove();
        }
    });
    $("#" + selectMenuId + " option[value='new']").prop("selected", "selected");
}

/**
 * function is used to show/hide the loading message on screen
 */
function loadingMessage(operation)
{
    if(!operation)
    {
        operation = 'show';
    }
    if (operation == 'show')
    {
        $(".go-loading").show();
    }
    else
    {
        $(".go-loading").hide();
    }
}