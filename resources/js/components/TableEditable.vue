<style>
    .pt-3-half {
        padding-top: 1.4rem;
    }
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="table" class="table-editable">
                    <span class="table-add float-right mb-3 mr-2">{{ $t('119') }}<a @click="tableInsert" href="#!" class="text-success"><i
                     class="fas fa-plus mx-2" aria-hidden="true"></i></a></span>
                    <table class="table table-bordered table-responsive-md text-center">
                    <thead class="thead-light">
                        <tr >
                            <th class="text-center">{{ $t('116') }}</th>
                            <th class="text-center">{{ $t('113') }}</th>
                            <th class="text-center">{{ $t('117') }}</th>
                            <th class="text-center">{{ $t('118') }}</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hide">
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td>
                                <span class="table-remove"><button type="button"
                                    class="btn btn-danger btn-rounded btn-sm my-0">{{ $t('106') }}</button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    <tr>
                        <td></td>
                        <td>{{ $t('120') }}</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td></td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
        return {
      };
    },
    methods:{
        tableInsert(){
            const $tableID = $('#table');
            const $BTN = $('#export-btn');
            const $EXPORT = $('#export');
            const newTr = `
            <tr class="hide">
            <td class="pt-3-half" contenteditable="true">Example</td>
            <td class="pt-3-half" contenteditable="true">Example</td>
            <td class="pt-3-half" contenteditable="true">Example</td>
            <td class="pt-3-half" contenteditable="true">Example</td>
            <td>
                <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>
            </td>
            </tr>`;

            $('.table-add').on('click', 'i', () => {
            const $clone = $tableID.find('tbody tr').first().clone(true).removeClass('hide table-line');
            if ($tableID.find('tbody tr').length === 0) {
                $('tbody').append(newTr);
            }
            $tableID.find('table').append($clone);
            });
            $tableID.on('click', '.table-remove', function () {
            $(this).parents('tr').detach();
            });
            // A few jQuery helpers for exporting only
            jQuery.fn.pop = [].pop;
            jQuery.fn.shift = [].shift;
            $BTN.on('click', () => {
            const $rows = $tableID.find('tr:not(:hidden)');
            const headers = [];
            const data = [];
            // Turn all existing rows into a loopable array
            $rows.each(function () {
                const $td = $(this).find('td');
                const h = {};
                // Use the headers from earlier to name our hash keys
                headers.forEach((header, i) => {
                h[header] = $td.eq(i).text();
                });
                data.push(h);
            });
            // Output the result
            $EXPORT.text(JSON.stringify(data));
            });
        }
    }
}
</script>
