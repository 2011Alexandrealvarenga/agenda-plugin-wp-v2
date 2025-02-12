jQuery(document).ready(function($) {
  let currentDate = new Date(); // Data atual

  // Inicializa o Datepicker
  $('#agenda-datepicker').datepicker({
      dateFormat: 'dd/mm/yy', // Formato da data
      onSelect: function(dateText) {
          // Quando uma data é selecionada, busca os posts
          $.ajax({
              url: agenda_ajax.ajax_url,
              type: 'POST',
              data: {
                  action: 'check_specific_day_posts',
                  date: dateText
              },
              success: function(response) {
                  $('#agenda-posts').html(response); // Substitui a lista de posts
                  $('#agenda-result').html(''); // Limpa a área de resultados (se houver)
              }
          });
      }
  });

  // Verificar posts do dia anterior
  $('#check-previous-day').click(function() {
      currentDate.setDate(currentDate.getDate() - 1); // Subtrai um dia
      const previousDay = $.datepicker.formatDate('yy-mm-dd', currentDate);

      $.ajax({
          url: agenda_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'check_specific_day_posts',
              date: previousDay
          },
          success: function(response) {
              $('#agenda-posts').html(response); // Substitui a lista de posts
              $('#agenda-result').html(''); // Limpa a área de resultados (se houver)
          }
      });
  });

  // Verificar posts do dia posterior
  $('#check-next-day').click(function() {
      currentDate.setDate(currentDate.getDate() + 1); // Adiciona um dia
      const nextDay = $.datepicker.formatDate('yy-mm-dd', currentDate);

      $.ajax({
          url: agenda_ajax.ajax_url,
          type: 'POST',
          data: {
              action: 'check_specific_day_posts',
              date: nextDay
          },
          success: function(response) {
              $('#agenda-posts').html(response); // Substitui a lista de posts
              $('#agenda-result').html(''); // Limpa a área de resultados (se houver)
          }
      });
  });
});