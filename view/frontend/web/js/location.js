require(['jquery', 'Magento_Ui/js/modal/modal', 'mage/translate', 'mage/url'],
    function ($, modal, $t, urlBuilder) {
    $("#content").hide();
    $("#text-city").html($("#city option:selected").text());
    // check login
    var dataLogin = 'guest';
    // check city in customer and city in api
    var CheckCity = false;
    var dataAddress = null;
    function Execute() {
        var url = BASE_URL+'location/customer/check';
        $.getJSON(url, function (data) {
            if(data == 'guest')
            {
                if($.cookie('city') == null)
                {
                    setDistrict($("#city").val());
                    return;
                }
                $("#city option").each(function () {
                    if($(this).text() == $.cookie('city'))
                    {
                        $(this).attr({'selected':true});
                        setDistrict($(this).val());
                        CheckCity = true;
                        return;
                    }
                });
                dataAddress = {'region':$.cookie('district'),'street':$.cookie('ward')};
                setAddress($.cookie('city'), $.cookie('district'), $.cookie('ward'));
            }
            else if(data == 'no-address')
            {
                RemoveCookie();
                dataLogin = 'auth';
                setDistrict($("#city").val());
            }
            else
            {
                dataLogin = 'auth';
                dataAddress = data;
                RemoveCookie();
                setAddress(data.city, data.region, data.street);

            }
        });
    }
    Execute();


    function setAddress(city, region, street) {
        $("#text-city").html(city);
        $("#text-district").html(region);
        $("#text-ward").html(street);
        $("#city option").each(function () {
            if($(this).text() == city)
            {
                $(this).attr({'selected':true});
                setDistrict($(this).val());
                CheckCity = true;
                return;
            }
        });
        if(!CheckCity)
        {
            $("#city").prepend("<option selected value='address-not-in-api'>"+city+"</option>");
            $("#district").prepend("<option selected value=''>"+region+"</option>");
            $("#ward").prepend("<option selected value=''>"+street+"</option>");
        }
    }

    function RemoveCookie() {
        $.cookie("city", 1, { expires : -7200 });
        $.cookie("district", 1, { expires : -7200 });
        $.cookie("ward", 1, { expires : -7200 });
    }

    var modaloption = {
        type: 'popup',
        modalClass: 'modal-popup',
        responsive: true,
        innerScroll: true,
        clickableOverlay: true,
        title: $t('Select Location'),
        buttons: [{
            text: $.mage.__('Save'),
            class: '',
            click: function () {
                saveLocation();
                this.closeModal();
            }
        }]
    };

    function saveLocation()
    {
        var city = $("#city option:selected").text();
        var district = $("#text-district").text();
        var ward = $("#text-ward").text();
        console.log(dataLogin);
        if(dataLogin == 'guest')
        {
            $.cookie("city", city, { expires : 7200 });
            $.cookie("district", district, { expires : 7200 });
            $.cookie("ward", ward, { expires : 7200 });
            return;
        }

        var url = BASE_URL+'location/address/save';
        $.ajax({
            url: url,
            data: {city: city, district: district, ward:ward},
            type: 'POST',
            success:function (data) {
                //console.log(data);
            },
            error:function (data) {
                console.log(data);
            }
        });
    }

    $("#select").click(function () {
        var callforoption = modal(modaloption, $("#content"));
        $("#content").modal('openModal');
    });

    $("#city").change(function () {
        var id = $(this).val();
        if(id == 'address-not-in-api')
        {
            $("#text-district").html(dataLogin.region);
            $("#text-ward").html(dataLogin.street);
            $("#district").html("<option selected value=''>"+dataLogin.region+"</option>");
            $("#ward").html("<option selected value=''>"+dataLogin.street+"</option>");
            return;
        }
        setDistrict(id);
        $("#text-city").html($("#city option:selected").text());
    });
    $("#district").change(function () {
        var id = $(this).val();
        setWard(id);
        $("#text-district").html($("#district option:selected").text());
    });
    $("#ward").change(function () {
        $("#text-ward").html($("#ward option:selected").text());
    });
    function setDistrict(id)
    {
        var url = BASE_URL+'location/district/get';
        $.ajax({
            url: url,
            data: {id: id},
            type: 'GET',
            success:function (data) {
                data = $.parseJSON(data);
                $("#district").html("");
                $("#text-district").html(data[0].Title);
                data.forEach(function (d) {
                    if(CheckCity && d.Title == dataAddress.region)
                    {
                        $("#district").append("<option selected value='"+d.ID+"'>"+d.Title+"</option>");
                        $("#text-district").html(d.Title);
                    }
                    else
                        $("#district").append("<option value='"+d.ID+"'>"+d.Title+"</option>");
                });
                setWard(data[0].ID);
            },
        });
    }
    function setWard(id) {
        var url = BASE_URL+'location/ward/get';
        $.ajax({
            url: url,
            data: {id: id},
            type: 'GET',
            success:function (data) {
                data = $.parseJSON(data);
                $("#ward").html("");
                $("#text-ward").html(data[0].Title);
                data.forEach(function (d) {
                    if(CheckCity && d.Title == dataAddress.street)
                    {
                        $("#ward").append("<option selected value='"+d.ID+"'>"+d.Title+"</option>");
                        $("#text-ward").html(d.Title);
                    }
                    else
                        $("#ward").append("<option value='"+d.ID+"'>"+d.Title+"</option>");
                });

            },
        });
    }
});