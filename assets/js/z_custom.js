$(document).ready(function () {
  function loadTable(pageLimit) {
    $.getJSON("data.php", function (data) {
      if (data.length > 0) {
        const columns = Object.keys(data[0]).map((key) => ({
          id: key,
          name: key.charAt(0).toUpperCase() + key.slice(1),
        }));

        const wrapper = document.getElementById("table-wrapper");
        const newWrapper = wrapper.cloneNode(false);
        wrapper.parentNode.replaceChild(newWrapper, wrapper);

        new gridjs.Grid({
          columns: columns,
          data: data.map((item) => columns.map((col) => item[col.id])),
          search: {
            enabled: true,
            placeholder: "🔍 Suche nach Beiträgen...",
          },
          height: "600px",
          resizable: true,
          fixedHeader: true,
          sort: {
            multiColumn: false,
          },
          pagination: {
            enabled: true,
            limit: pageLimit,
            summary: true,
          },
          className: {
            table: "table-table table-body green-table",
            tr: "table-tr",
            td: "table-td",
            th: "table-th",
            search: "table-search",
            sort: "table-sort",
            pagination: "table-pagination",
            paginationButton: "table-pagination-button",
            paginationButtonNext: "table-pagination-next",
            paginationButtonCurrent: "table-pagination-current",
            paginationButtonPrev: "table-pagination-previous",
            loading: "table-loading",
          },
          style: {
            td: {
              "white-space": "nowrap",
            },
          },
          language: {
            search: {
              placeholder: "🔍 Suche nach Beiträgen...",
            },
            sort: {
              sortAsc: "Aufsteigend sortieren",
              sortDesc: "Absteigend sortieren",
            },
            pagination: {
              previous: "Zurück",
              next: "Weiter",
              showing: "Zeige",
              to: "bis",
              of: "von",
              results: "Einträgen",
            },
            loading: "Lade Beiträge...",
            noRecordsFound: "Keine Beiträge gefunden",
            error: "Fehler beim Laden der Beiträge",
          },
        }).render(newWrapper);
      } else {
        document.getElementById("table-wrapper").innerText =
          "Keine Beiträge gefunden.";
      }
    }).fail(() => {
      document.getElementById("table-wrapper").innerText =
        "Fehler beim Laden der Beiträge.";
    });
  }

  // Erste Initialisierung mit aktuellem Dropdown-Wert
  loadTable(parseInt($("#pageSize").val(), 10));

  // Bei Änderung der Eintragsanzahl
  $("#pageSize").on("change", function () {
    const newLimit = parseInt($(this).val(), 10);
    loadTable(newLimit);
  });
});
