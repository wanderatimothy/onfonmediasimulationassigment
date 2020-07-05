// my vars
var smsSimulator = document.getElementById('smsSimulator');
var Feed = document.getElementById('feed');
var msg_body = document.getElementById('msg_body');
var phone = document.getElementById('phone');
var match_data;
var lastlimit = 0;
let initTime = 10000

var setSmsIinterval = setInterval(function () {
    console.log("start interval")
    smsTimeOut()
}, initTime)
function next3(n, array) {
    // console.log(array)
    if (typeof array !== "undefined") {
        var msg = '';
        array = array.slice(n, 3);

        console.log(array);

        for (i = 0; i < array.length; i++) {
            // console.log(array[i].user_name)
            msg += `${array[i].user_name} , ${array[i].age} , ${array[i].user_id} . `
        }
        return msg;
    } else {
        return '';
    }

}


function smsTimeOut() {
    var formdata = new FormData(smsSimulator);
    var smsBody = {
        phone: formdata.get('phone'),
        code: formdata.get('too')
    }
    $.ajax({
        type: 'post',
        url: 'api/start.php',
        data: {
            phone: smsBody.phone,
            msg_body: 'timeout',
            code: smsBody.code
        },
        success: function (response) {

            data = JSON.parse(response);
            if (data.resp) {
                var p = document.createElement('p');
                p.className = 'item';
                text = document.createTextNode(data.resp);
                p.appendChild(text);
                Feed.appendChild(p);
            }
            console.log("clear and  set new")
            clearInterval(setSmsIinterval)
            setSmsIinterval

        },
        error: function (response) {
        }

    })
}

phone.addEventListener('change', (event) => {
    setSmsIinterval
});


smsSend = function (event) {

    event.preventDefault();
    var formdata = new FormData(smsSimulator);
    var smsBody = {
        phone: formdata.get('phone'),
        msg_body: new String(formdata.get('msg_body')).trim(),
        code: formdata.get('too')
    }

    if (smsBody.msg_body.length <= 160) {




        msg = new String(smsBody.msg_body);
        if (msg.trim() != '') {
            var myP = document.createElement('p');
            myP.className = "myp";
            var text = document.createTextNode(smsBody.msg_body);
            myP.appendChild(text);
            Feed.appendChild(myP);
        }
        msg = new String(smsBody.msg_body);
        if (msg.toLocaleLowerCase().trim() == 'next') {

            // perform a different  search for the next person
            if (typeof (match_data) == "undefined") {
                $.ajax({
                    type: 'post',
                    url: 'api/start.php',
                    data: smsBody,
                    success: function (res, textStatus) {
                        // console.log("resp", res)
                        if (textStatus == 'success') {
                            data = JSON.parse(res);
                            match_data = data.resp;
                            // console.log(data)

                            // create paragraf
                            var p = document.createElement('p');
                            p.className = 'item';
                            text = document.createTextNode(next3(2, match_data));
                            p.appendChild(text);
                            Feed.appendChild(p);

                            lastlimit = lastlimit + 3;

                        }

                    },
                    error: function (resp) {
                        console.log(resp);

                    }
                });

            } else {

                // create paragraf
                lastlimit += 3;
                var p = document.createElement('p');
                p.className = 'item';
                text = document.createTextNode(next3(lastlimit, match_data));
                p.appendChild(text);
                Feed.appendChild(p);


            }


        } else {

            // Nomal Execution

            $.ajax({
                type: "post",
                url: "api/start.php",
                data: smsBody,
                success: function (response, textStatus) {
                    // timer.reset();
                    console.log('timer resset');

                    if (textStatus === 'success') {
                        setTimeout(function () {
                            data = JSON.parse(response);
                            if (data.resp != '') {
                                // timer.reset();
                                var p = document.createElement('p');
                                p.className = 'item';
                                text = document.createTextNode(data.resp);
                                p.appendChild(text);
                                Feed.appendChild(p);
                            } else {
                                // timer.reset();
                                $.notify("message not sent try again")
                            }
                        }, 600)
                    } else {

                        var msgNotsent = `<p class="text-danger"> Message not sent </p>`;
                        Feed.appendChild(msgNotsent);
                    }

                },
                error: function (response) {
                    alert(response);
                }
            });

        }


    } else {
        $.notify('message should not exceed 160 characters');
    }







}
