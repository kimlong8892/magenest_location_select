require(['jquery', 'Magento_Ui/js/modal/modal', 'mage/translate'], function ($, modal, $t) {
    $("#content").hide();
    $("#text-city").html($("#city option:selected").text());
    var modaloption = {
        type: 'popup',
        modalClass: 'modal-popup',
        responsive: true,
        innerScroll: true,
        clickableOverlay: true,
        title: $t('Select Location')
    };
    $("#select").click(function () {
        var callforoption = modal(modaloption, $("#content"));
        $("#content").modal('openModal');
    });
    setDistrict($("#city").val());
    $("#city").change(function () {
        setDistrict($(this).val());
        $("#text-city").html($("#city option:selected").text());
    });
    $("#district").change(function () {
        setWard($(this).val());
        $("#text-district").html($("#district option:selected").text());
    });
    $("#ward").change(function () {
        $("#text-ward").html($("#ward option:selected").text());
    });
    function setDistrict(id)
    {
        $.getJSON('location/district/get?id='+id, function (data) {
            $("#district").html("");
            data.forEach(function (d) {
                $("#district").append("<option value='"+d.ID+"'>"+d.Title+"</option>");
            });
            setWard(data[0].ID);
            $("#text-district").html(data[0].Title);
        });
    }
    function setWard(id) {
        $.getJSON('location/ward/get?id='+id, function (data) {
            $("#ward").html("");
            data.forEach(function (d) {
                $("#ward").append("<option value='"+d.ID+"'>"+d.Title+"</option>");
            });
            $("#text-ward").html(data[0].Title);
        });
    }
});