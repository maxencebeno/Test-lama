function changeListMarque(rubrique, wrap)
{
    if (rubrique != '' && rubrique != '-1')
    {
        $(wrap + " .marque").html('<option value="-1">Chargement en cours ...</option>');
        $.ajax({
            url: '/app_dev.php/ajax/getMarque/' + rubrique,
            success: function (data) {
                $(wrap + " .marque").html(data);
                $(wrap + " .marque").val('-1');
                $(wrap + " .marque").trigger("chosen:updated");
            }
        });
    }
}

function changeListModele(rubrique, type, wrap)
{
    if (rubrique != '' && rubrique != '-1')
    {
        $(wrap + " .modele").html('<option value="-1">Chargement en cours ...</option>');
        $.ajax({
            url: '/app_dev.php/ajax/getModele/' + rubrique + '/' + type,
            success: function (data) {
                $(wrap + " .modele").html(data);
                $(wrap + " .modele").val('-1');
                $(wrap + " .modele").trigger("chosen:updated");
            }
        });
    }
}


$(document).ready(function () {

    $('.search_imprimante').find('.typeimprimante').change(function () {
        if ($(this).val() != -1)
            changeListMarque($(this).val(), '.search_imprimante');
    });
    
    $('.search_imprimante').find('.marque').change(function () {
        if ($(this).val() != -1)
            changeListModele($(this).val(), $('.search_imprimante .typeimprimante').val(), '.search_imprimante');
    });

});