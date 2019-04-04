$('#contact-form').on('submit', function (event) {
    $(this).find('p').text('');
    event.preventDefault();
    $('#name').removeClass('contact-error');
    $('#phone').removeClass('contact-error');
    $('#email').removeClass('contact-error');
    $('#st-que').removeClass('contact-error');
    $('#lg-que').removeClass('contact-error');

    var emailRegexp = /^[\w-]+(\.[\w-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i,
            phoneRegexp = /^0(2|3|4|5|8|9)(\d)?\d{7}$/,
            validate = false,
            name = $('#name'),
            phone = $('#phone'),
            email = $('#email'),
            stQue = $('#st-que'),
            lgQue = $('#lg-que'),
            userData = {
                name: name.val().trim(),
                email: email.val().trim(),
                phone: phone.val().trim(),
                stQue: stQue.val().trim(),
                lgQue: lgQue.val().trim()
            },
            submit = $('#submit');
    ;

    submit.attr('disabled', true);

    if (userData.name.length < 2 || userData.name.length > 50) {
        validate = true;
        name.next().text('אנא כתוב 2-50 תווים');
        name.addClass('contact-error');
    }

    if (!emailRegexp.test(userData.email)) {
        validate = true;
        email.next().text('אימייל שגוי');
        email.addClass('contact-error');
    }


    if (!phoneRegexp.test(userData.phone)) {
        validate = true;
        phone.next().text('טלפון שגוי');
        phone.addClass('contact-error');
    }

    if (userData.stQue.length < 2 || userData.stQue.length > 50) {

        validate = true;
        stQue.next().text('אנא כתוב 2-50 תווים');
        stQue.addClass('contact-error');
    }

    if (userData.lgQue.length < 2 || userData.lgQue.length > 50) {
        validate = true;
        lgQue.next().text('אנא כתוב 2-50 תווים');
        lgQue.addClass('contact-error');
    }

    console.log(userData);

    if (validate) {
        submit.attr('disabled', false);
    } else {

        $.ajax({
            type: 'POST',
            url: 'app/data.php',
            dataType: 'html',
            data: userData,
            success: function (res) {
                if (res == 1) {
                    submit.next().text('הודעתך נשלחה בהצלחה!!');
                    name.val('');
                    email.val('');
                    phone.val('');
                    stQue.val('');
                    lgQue.val('');

                } else {
                    submit.next().text('חלה שגיאה. אנא נסה שנית מאוחר יותר');
                }

            }
        });
    }



});
