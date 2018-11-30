$(document).ready(function(){
    var data;

    $('.object-input').hide();
    $('.object-category').hide();

    axios.get(baseUrl + 'api/channel').then(function(response) {
        data = response.data.data.channel;

        window.channels = _.chain(data).map(function(item) {
            return {
                id: item.id,
                media: item.media.name,
                icon: item.media.icon,
                layout: item.media.layout,
                category: item.media.category
            }
        }).value();

        window.medias = _.chain(data).map(function(item) {
            return {
                id: item.media.id,
                name: item.media.name,
                icon: item.media.icon,
                layout: item.media.layout,
                category: item.media.category
            }
        }).value();

        var filteredMedia = _.uniqBy(window.medias, function(item){
            return item.name || item.category
        });

        _.each(filteredMedia, function(media) {
            $('#media-type').append('<option value="'+media.id+'" ' +
                    'data-layout="'+media.layout+'" ' +
                    'data-content="<img src=\'' + baseUrl+media.icon + '\' class=\'media-select-icon\'> ' +
                '<span>'+media.name+'</span>">'+media.name+'</option>')
        });
        $('#media-type').selectpicker('destroy').selectpicker('render');
    });

    $('#media-type').change(function() {
        $('.object-input').hide();
        $('.object-category').hide();
        var val = $(this).val();

        var objTypes = _.filter(data, function(item){ return item.media_id === val})
            .map(function(item) {
                return {
                    id: item.crawling_type.id,
                    name: item.crawling_type.name
                }
            });

        $('#object-type').html('<option value="" disabled selected>Select Type</option>');

        objTypes.forEach(function(objType) {
            var name = objType.name;
            if(name === 'Hashtag') name += ' (#)';
            else if(name === 'Person') name += '(@)';

            $('#object-type').append('<option value="'+objType.id+'">'+name+'</option>')
        });

        $('#object-type').selectpicker('destroy').selectpicker('render');

        var selectedObj = _.find(window.medias, function (item) { return item.id === val });

        if (selectedObj.category !== null) {
            var categories = _.filter(window.medias, function (item) { return item.name === selectedObj.name });

            $('#media-category').html('<option value="" disabled selected>Select Category</option>');

            categories.forEach(function (category) {
                $('#media-category').append('<option value="' + category.id + '">' + category.category + '</option>');
            });

            $('#media-category').selectpicker('destroy').selectpicker('render');

            $('.object-category').show();
        }

        $('#media-type').data('category', val);
    });

    $('#media-category').change(function () {
        var val = $(this).val();

        $('#media-type').data('category', val);
    });

    $('#object-type').change(function(e) {
        $('.object-input').hide();

        switch (parseInt($(this).val())) {
            case 1 :
                $('#keyword').show();
                break;
            case 2 :
                $('#hashtag').show();
                break;
            case 3 :
                $('#person').show();
                break;
            case 4:
                $('#tag').show();
                break;
            case 5:
                $('#fanpage').show();
                break;
        }
    })
});
