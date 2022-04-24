let cardid = $("input[name*='card_id']");
$(".btnedit").click(e => {
    let textvalues = displayData(e);
    let cardid = $("input[name*='card_id']");
    let cardname = $("input[name*='card_name']");
    let cardtype = $("input[name*='card_type']");
    let cardset = $("input[name*='card_set']");
    let price = $("input[name*='price']");

    cardid.val(textvalues[0]);
    cardname.val(textvalues[1]);
    cardtype.val(textvalues[2]);
    cardset.val(textvalues[3]);
    price.val(textvalues[4].replace("$", ""));

});




function displayData(e) {
    let id = 0;
    let td = $("#tbody tr td");
    let textvalues = [];
    let td2 = Object.values(td);
    td2.pop();
    td2.pop();
    for (const value of td2) {
        if (value.dataset.id == e.target.dataset.id) {
            textvalues[id++] = value.textContent;
        }
    }
    return textvalues;
}