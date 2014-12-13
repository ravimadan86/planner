$(function () {
    
});

/**
 * function sends an ajax request to send subscription emails
 */
function sendSubscriptionMail(mailgroup_id)
{
    loadingMessage('show');
    $.ajax({
        url: baseUrl+'/index.php/mailgroups/sendmailgroupsubscriptionmail', //Yii.urls.sendmailgroupsubscriptionmail
        cache: false,
        type: "POST",
        dataType: "JSON",
        data: {'mailgroup_id' : mailgroup_id},
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


function markSubscribeUnsubscribe(mailgroup_id, person_id, sub)
{
    loadingMessage('show');
    $.ajax({
        url: baseUrl+'/index.php/mailgroups/markSubscribeUnsubscribe',
        cache: false,
        type: "POST",
        dataType: "JSON",
        data: {'mailgroup_id' : mailgroup_id, 'person_id': person_id, 'subscribe' : sub},
        success: function(data){
            //data = JSON.parse(data);
            if (data.success == "1")
            {
                alert(data.message);
                $.fn.yiiGridView.update('mailgroups-grid');
            }
            else
            {
                alert(data.message);
            }
            loadingMessage('hide');
        },
        error: function(){
            alert("Subscribe/Unsubscribe failed");
            loadingMessage('hide');
        }
    });
}