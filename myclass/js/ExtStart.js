

Ext.onReady(function() {
    var myData = [
        ['Apple',29.89,0.24,0.81,'9/1 12:00am'],
        ['Ext',83.81,0.28,0.34,'9/12 12:00am'],
        ['Google',71.72,0.02,0.03,'10/1 12:00am'],
        ['Microsoft',52.55,0.01,0.02,'7/4 12:00am'],
        ['Yahoo!',29.01,0.42,1.47,'5/22 12:00am']
    ];

    var ds = new Ext.data.SimpleStore({
        fields: [
            {name: 'company'},
            {name: 'price', type: 'float'},
            {name: 'change', type: 'float'},
            {name: 'pctChange', type: 'float'},
            {name: 'lastChange', type: 'date', dateFormat: 'n/j h:ia'}
        ]
    });
    ds.loadData(myData);

    var colModel = new Ext.grid.ColumnModel([
        {header: "Company", width: 120, sortable: true, dataIndex: 'company'},
        {header: "Price", width: 90, sortable: true, dataIndex: 'price'},
        {header: "Change", width: 90, sortable: true, dataIndex: 'change'},
        {header: "% Change", width: 90, sortable: true, dataIndex: 'pctChange'},
        {header: "Last Updated", width: 120, sortable: true,
            renderer: Ext.util.Format.dateRenderer('m/d/Y'),
                        dataIndex: 'lastChange'}
    ]);

    var grid = new Ext.grid.GridPanel({ height:200, width:600, ds: ds, cm: colModel});
    grid.render(document.body);
    grid.getSelectionModel().selectFirstRow();
});

Ext.onReady(function(){

	var panel = new Ext.TabPanel({
    width: 200,
    height: 200,
    activeItem: 0, // index or id
    items:[{
        title: 'Tab 1',
        html: 'This is tab 1 content.'
    },{
        title: 'Tab 2',
        html: 'This is tab 2 content.'
    },{
        title: 'Tab 3',
        html: 'This is tab 3 content.'
    }]
});
panel.render(document.body);




});