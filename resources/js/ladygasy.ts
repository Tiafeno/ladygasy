import { isArray, isNumber, isString } from "lodash";

$(function() {
  ( <any>$('.dropdown-toggle')).dropdown();
  $('#menu-bar').on('click', function(ev) {
    console.log(ev);
    $(ev.currentTarget).toggleClass("change");
    $('#nav').toggleClass("change");
    $('#menu-bg').toggleClass("change-bg");
    $('body').toggleClass("menu-open");
  });

  $('#single-product-quantity').on('change', (e) => {
    const quantity = $(e.currentTarget).val();
    const unitPrice = $('input#single-unit-price').val();
    if (isString(quantity) && isString(unitPrice))  {
      $('#single-product-price').text(parseInt(quantity) * parseInt(unitPrice));
    }
  });

  $('.single-product-attribute').on('change', (ev) => {
    const option = $(ev.currentTarget).children(':selected');
    let price = option.data('price');
    let quantityMax = option.data('quantity');
    let inputQuantity = $("#single-product-quantity").val();
    price = parseInt(price);
    quantityMax = parseInt(quantityMax);

    // vérification de quantité
    if (isString(inputQuantity)) {
      inputQuantity = parseInt(inputQuantity);

      // Mettreà jour le prix
      $('#single-unit-price').val(price);
      $('#single-product-price').text(inputQuantity * price);

      if (inputQuantity > quantityMax) {
        $("#single-product-quantity").val(quantityMax);
      }
    }

  });
})



