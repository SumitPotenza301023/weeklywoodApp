/**
 * ========================================
 * contest-list
 * ========================================
 */
$( '#contestdatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4, 5, 6]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.contest_list,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

$( '#tbl_banners' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_banner,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

$( '#promocodedatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4, 5, 6]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_all_promocodes,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

$( '#usersdatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4, 5]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_user,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

$( '#pagedatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_pages,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

const urlParams = new URLSearchParams( window.location.search );
if ( urlParams.get( 'contest-id' ) )
{
    $( '#participantdatatable' ).DataTable( {
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 1, 2, 3, 4, 5, 6]
        }],
        "order": [],
        "serverSide": true,
        "processing": true,
        "ajax": {
            url: weekly.config.get_participant,
            data: { contest_id: urlParams.get( 'contest-id' ) },
            type: 'POST'
        },
        "fnRowCallback": function ( nRow, aData, iDisplayIndex )
        {
            $( "td:first", nRow ).addClass( 'p-0 text-center' );

            return nRow;
        }
    } );
}

$( '#transactiondatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3, 4]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_transactions,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).addClass( 'p-0 text-center' );
        $( "td:first", nRow ).html( iDisplayIndex + 1 );

        return nRow;
    }
} );

$( '#pointtransactiondatatable' ).DataTable( {
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0, 1, 2, 3]
    }],
    "order": [],
    "serverSide": true,
    "processing": true,
    "ajax": {
        url: weekly.config.get_point_transactions,
        type: 'POST'
    },
    "fnRowCallback": function ( nRow, aData, iDisplayIndex )
    {
        $( "td:first", nRow ).addClass( 'p-0 text-center' );
        $( "td:first", nRow ).html( iDisplayIndex + 1 );
        return nRow;
    }
} );

// const urlParams = new URLSearchParams( window.location.search );
// console.log( urlParams );
if ( urlParams.get( 'c_id' ) )
{
    console.log( "result" );
    $( '#contestresultdatatable' ).DataTable( {
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 1, 2, 3, 4, 5]
        }],
        "order": [],
        "serverSide": true,
        "processing": true,
        "ajax": {
            url: weekly.config.get_contest_result,
            data: { c_id: urlParams.get( 'c_id' ) },
            type: 'POST'
        },
        "fnRowCallback": function ( nRow, aData, iDisplayIndex )
        {
            $( "td:first", nRow ).addClass( 'p-0 text-center' );
            $( "td:first", nRow ).html( iDisplayIndex + 1 );

            return nRow;
        }
    } );
}