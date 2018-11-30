$(document).ready(function(){

    $('.card .body').waitMe(loading);

    axios.get(baseUrl + 'api/setting').then(function(response) {
       var profile = response.data;

       if(profile.success) {

           $('.card .body').waitMe('hide');

           var data = profile.data.account;
           $('#name').html(data.fullname);
           $('#username').html(data.username);
           $('#email').html(data.email);
           $('#company').html(data.account.company_name);
           try {
               $('#department').html(data.department.name);
           } catch (e) {
               $('#department').html('<span class="col-red">Not Set</span>');
           }
           $('#role').html(data.role.name);
       }
    });
});