
$(document).ready(function() {

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $("#createUser").click(function(e) {
        e.preventDefault();
        
        if (
                $("#nameUser").val() != "" && 
                $("#emailUser").val() != "" && 
                $("#passUser").val() != "" && 
                $("#languageUser").val() != ""
            ) {
  
                    $.ajax({type: "POST",
                        url: "/admin/create-user",
                        data: { nameUser: $("#nameUser").val(), emailUser: $("#emailUser").val(), passUser: $("#passUser").val(), languageUser: $("#languageUser").val() },
                        success:function(result) {
                            
                            $("#nameUser").val('');
                            $("#emailUser").val('');
                            $("#passUser").val('');
                            $("#languageUser").val('');
                            
                            $(location).attr('href','/admin/users');
                        },
                        error:function(result) {
                            alert('error');
                        }
                    });
                } else {

                    alert("Faltan datos");

                }
    });

    $("#createRole").click(function(e) {
        e.preventDefault();
  
        if ($("#nameRol").val() == ""){
            //alert("Empty response");
            return null;
        }

        $.ajax({type: "POST",
            url: "/admin/create-rol",
            data: { nameRol: $("#nameRol").val() },
            success:function(result) {
                $("#nameRol").val('');

                $(location).attr('href','/admin/roles');
            },
            error:function(result) {
                alert('error');
            }
        });

    });

    $("#createPermission").click(function(e) {
        e.preventDefault();
  
        if ($("#namePermission").val() == ""){
            return null;
        }

        $.ajax({type: "POST",
            url: "/admin/create-permission",
            data: { namePermission: $("#namePermission").val() },
            success:function(result) {
                $("#namePermission").val('');

                $(location).attr('href','/admin/permissions');
            },
            error:function(result) {
                alert('error');
            }
        });

    });

    $("#createCategory").click(function(e) {
        e.preventDefault();

        if ($("#category_en").val() == "" || $("#category_es").val() == "" || $("#category_fr").val() == ""){
            return null;
        }

        $.ajax({type: "POST",
            url: "/ticketing/create-category",
            data: { category_en: $("#category_en").val(), category_es: $("#category_es").val(), category_fr: $("#category_fr").val()},
            success:function(result) {
                $("#nameCategory").val('');

                $(location).attr('href','/ticketing/manage');
            },
            error:function(result) {
                alert('error');
            }
        });

    });

    $("#addRolToUser").click(function(e) {
        e.preventDefault();

        if ($('#selRoles').val() == "")
            return false;

        $(location).attr('href','/admin/add-user-rol/' + $('#hidUserId').val() + '/rol/' + $('#selRoles').val());

    });

    $("#addPErmissionToRol").click(function(e) {
        e.preventDefault();

        if ($('#selPerm').val() == "")
            return false;

        $(location).attr('href','/admin/add-rol-perm/' + $('#hidRolId').val() + '/perm/' + $('#selPerm').val());

    });

    

    $('a[name^="linkDeleteRole"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var rolname = $(this).attr('rolname');
        var username = $(this).attr('username');

        if(confirm("Are you sure you want to delete the rol: " + rolname + " from the user: " + username + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="linkDeleteTicketFile"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');

        var file = $(this).attr('file');

        if(confirm("Are you sure you want to delete the file: " + file + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="linkRevokePermission"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var rolname = $(this).attr('rolname');

        if(confirm("Are you sure you want to delete the permission: " + rolname + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="linkRevokeRol"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var rolname = $(this).attr('rolname');

        if(confirm("Are you sure you want to revoke the rol: " + rolname + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="linkDeletePerm"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var permname = $(this).attr('permname');

        if(confirm("Are you sure you want to delete the permission: " + permname + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="linkDeleteDocument"]' ).click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var permname = $(this).attr('permname');

        if(confirm("Are you sure you want to delete the document: " + permname + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $("#searchButton").click(function(e) {

        if ($("#searchText").val() == "" ){
            e.preventDefault();
        }

    });

    $('a[name^="deleteFileTicket"]').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var fileName = $(this).attr('fileName');

        if(confirm("Are you sure you want to delete the file: " + fileName + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="deleteFileProof"]').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var fileName = $(this).attr('fileName');

        if(confirm("Are you sure you want to delete the file: " + fileName + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="updateStatusLaboratory"]').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var laboratory = $(this).attr('laboratory');

        if(confirm("Are you sure you want change the status to: " + laboratory + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="deleteProductOutOfStock"]').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var product = $(this).attr('product');

        if(confirm("Are you sure you want delete the product: " + product + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $( 'input:checkbox[id^="selected_file"]').click(function(e) {

        var record_id = $(this).attr('record_id');
        var order_id = $(this).attr('order_id');

        if(confirm("Are you sure you want change the status ?")){
            var href = '/recordings-change-status/' + record_id + '/' + order_id ;

            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $( 'input:checkbox[id^="selected_tick"]').click(function(e) {

        var item_id = $(this).attr('item_id');

        if(confirm("Are you sure you want change the status ?")){
            var href = '/search-order-dispute/tick/' + item_id  ;

            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $( 'input:checkbox[id^="selected_dispute"]').click(function(e) {

        var orderNum = $(this).attr('orderNum');
        var status = $(this).attr('status');

        if(confirm("Are you sure you want change the status ?")){
            var href = '/search-order-dispute/status/' + orderNum + '/show/' + status ;

            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    $('a[name^="validateOrderDispute"]').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var order = $(this).attr('order');

        if(confirm("Are you sure you want to validate the dispute for order: " + order + " ?")){
            $(location).attr('href',href);
        }
        else{
            return false;
        }
    });

    function contieneCadena(cadena, subcadena) {
        return cadena.includes(subcadena);
      }

    function collapseMenu (){

        

        if ( contieneCadena(window.location.pathname, "/admin/users") || 
                    contieneCadena(window.location.pathname, "/admin/roles") || 
                    contieneCadena(window.location.pathname, "/admin/permissions") ||
                    contieneCadena(window.location.pathname, '/admin/user-roles/') || 
                    contieneCadena(window.location.pathname, '/admin/add-user-rol/') || 
                    contieneCadena(window.location.pathname, '/admin/delete-user-rol/') || 
                    contieneCadena(window.location.pathname, '/admin/view-rol/') || 
                    contieneCadena(window.location.pathname, '/admin/add-rol-perm/') || 
                    contieneCadena(window.location.pathname, '/admin/delete-permission/') || 
                    contieneCadena(window.location.pathname, '/admin/revoke-rol/') || 
                    contieneCadena(window.location.pathname, '/admin/view-rol-users/') || 
                    contieneCadena(window.location.pathname, '/admin/view-perm-roles/') || 
                    contieneCadena(window.location.pathname, '/admin/delete-rol-perm/') || 
                    contieneCadena(window.location.pathname, '/admin/new-user') || 
                    contieneCadena(window.location.pathname, '/admin/create-user/') || 
                    contieneCadena(window.location.pathname, '/admin/edit-user/')
                    ){
                            $("#collapseAdmin").addClass('show');
        } else if ( contieneCadena(window.location.pathname, "/admin/searcher/main") ||
                    contieneCadena(window.location.pathname, "/admin/searcher/search") ||
                    contieneCadena(window.location.pathname, "/order/view-order")
        
                    ) {
                            $("#collapseSearcher").addClass('show');
        } else if (
                    contieneCadena(window.location.pathname, "/admin/dataloader/sage") || 
                    contieneCadena(window.location.pathname, '/admin/dataloader/gls') ||
                    contieneCadena(window.location.pathname, '/admin/dataloader/send-gls') ||
                    contieneCadena(window.location.pathname, '/admin/dataloader/proof') ||
                    contieneCadena(window.location.pathname, '/admin/searcher/view-product')
                    
                    ) 
        {
           $("#collapseDataLoader").addClass('show');
                        
        } else if (contieneCadena(window.location.pathname, "/ticketing")) {
            $("#collapseTicketing").addClass('show');
            
        } else if (contieneCadena(window.location.pathname, "/documents")) {
            $("#collapseDocuments").addClass('show');
            
        } else if (contieneCadena(window.location.pathname, "/file-generator")) {
            $("#collapseFile").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/products-out-of-stock") ||
            contieneCadena(window.location.pathname, "/new-products-out-of-stock") ||
            contieneCadena(window.location.pathname, "/create-products-out-of-stock") ||
            contieneCadena(window.location.pathname, "/edit-products-out-of-stock") ||
            contieneCadena(window.location.pathname, "/update-products-out-of-stock") ||
            contieneCadena(window.location.pathname, "/delete-products-out-of-stock")
        ) {
            $("#collapseOut").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/scoring/pharmacies") ||
            contieneCadena(window.location.pathname, "/scoring/update-score") ||
            contieneCadena(window.location.pathname, "/update-score") ||
            contieneCadena(window.location.pathname, "/scoring/search") ||
            contieneCadena(window.location.pathname, "/scoring/pharmacy-scoring") ||
            contieneCadena(window.location.pathname, "/scoring/laboratories")       
        ) {
            $("#collapseScore").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/laphal/")       
        ) {
            $("#collapseLaphal").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/recording-search")     
        ) {
            $("#collapseSearch").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/search-order-dispute")     
        ) {
            $("#collapseDispute").addClass('show');
        } else if (
            contieneCadena(window.location.pathname, "/recovery")     
        ) {
            $("#collapseRecovery").addClass('show');
        } else if (contieneCadena(window.location.pathname, "/dashboard")){
            //alert(window.location.pathname);
        }
        else {
            alert(window.location.pathname);
        }
    }

    collapseMenu ();
});


