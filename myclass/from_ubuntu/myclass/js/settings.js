	var timeLimit = new Ext.form.TextField({
		name		: 'time-limit',
		allowBlank	: false,
		value		: '1200',
		fieldLabel	: 'time limit',
		blankText	: 'Enter Time Limit (in seconds)',
		autoWidth	: true,
		height		: 20,
	});

	var antsPerColony = new Ext.form.TextField({
		name		: 'apc',
		id			: 'apc',
		allowBlank	: false,
		value		: '1',
		labelWidth	: 100,
		fieldLabel	: 'apc',
		blankText	: 'Enter value for APC',			
	});
		
	var cg = new Ext.form.TextField({
		name		: 'cg',
		allowBlank	: false,
		value		: '3',
		labelWidth	: 100,
		fieldLabel	: 'cg',
		blankText	: 'Enter value for CG',			
	});
	
	var alpha = new Ext.form.TextField({
		name		: 'alpha',
		allowBlank	: false,
		value		: '1',
		labelWidth	: 100,
		fieldLabel	: 'alpha',
		blankText	: 'Enter value for Alpha',			
	});

	var beta = new Ext.form.TextField({
		name		: 'beta',
		allowBlank	: false,
		value		: '1',
		labelWidth	: 100,
		fieldLabel	: 'beta',
		blankText	: 'Enter value for Beta',			
	});

	var pr = new Ext.form.TextField({
		name		: 'pr',
		allowBlank	: false,
		value		: '0.2',
		labelWidth	: 100,
		fieldLabel	: 'pr',
		blankText	: 'Enter value for pr',			
	});
	
	var ad = new Ext.form.TextField({
		name		: 'ad',
		allowBlank	: false,
		value		: '5',
		labelWidth	: 100,
		fieldLabel	: 'ad',
		blankText	: 'Enter value for ad',			
	});
	
	var zap = new Ext.form.TextField({
		name		: 'zap',
		allowBlank	: false,
		value		: '10',
		labelWidth	: 100,
		fieldLabel	: 'zap',
		blankText	: 'Enter value for zap',			
	});
	
	var iap = new Ext.form.TextField({
		name		: 'iap',
		allowBlank	: false,
		value		: '1000',
		labelWidth	: 100,
		fieldLabel	: 'iap',
		blankText	: 'Enter value for iap',			
	});
	
	var qi = new Ext.form.TextField({
		name		: 'qi',
		allowBlank	: false,
		value		: '999999',
		labelWidth	: 100,
		fieldLabel	: 'qi',
		blankText	: 'Enter value for qi',			
	});	
	
	var m = new Ext.form.TextField({
		name		: 'm',
		allowBlank	: false,
		value		: '1',
		labelWidth	: 100,
		fieldLabel	: 'm',
		blankText	: 'Enter value for m',			
	});
	
	var fullEval = new Ext.form.TextField({
		name		: 'fullEval',
		allowBlank	: false,
		value		: 'true',
		labelWidth	: 100,
		fieldLabel	: 'fullEval',
		blankText	: 'Enter value for fullEval',			
	});
	
	var ils = new Ext.form.TextField({
		name		: 'ils',
		allowBlank	: false,
		value		: '10',
		labelWidth	: 100,
		fieldLabel	: 'ils',
		blankText	: 'Enter value for ils',			
	});
	
	var ls = new Ext.form.TextField({
		name		: 'ls',
		allowBlank	: false,
		value		: 'false',
		labelWidth	: 100,
		fieldLabel	: 'ls',
		blankText	: 'Enter value for ls',			
	});
	
	var ibu = new Ext.form.TextField({
		name		: 'ibu',
		allowBlank	: false,
		value		: 'true',
		labelWidth	: 100,
		fieldLabel	: 'ibu',
		blankText	: 'Enter value for ibu',			
	});
	
	var str = new Ext.form.TextField({
		name		: 'str',
		allowBlank	: false,
		value		: '12',
		labelWidth	: 100,
		fieldLabel	: 'str',
		blankText	: 'Enter value for str',			
	});
	
	var pd = new Ext.form.TextField({
		name		: 'pd',
		allowBlank	: false,
		value		: '1',
		labelWidth	: 100,
		fieldLabel	: 'pd',
		blankText	: 'Enter value for pd',	
				
	});
	

	var erlangSettings = new Ext.FormPanel({
		monitorValid	: true,
		id				: 'erlang-settings',
		items			: [timeLimit, antsPerColony, cg, alpha, beta, pr, ad, zap, iap, qi, m, fullEval, ils, ls, ibu, str, pd],
		title			: 'Erlang Process Parameter Settings',
		autoWidth		: true,
		frame			: true,
		iconCls			: 'erlang',
	});
	
	var fieldDescriptions = new Ext.FormPanel({
		monitorValid	: true,
		id				: 'field-descriptions',
		items			: [
		{xtype: 'displayfield', fieldLabel: 'timelimit', html: 'The time limit (in seconds) for the entire search operation'},
		{xtype: 'displayfield', fieldLabel: 'apc', html: 'Number of ants per colony'},
		{xtype: 'displayfield', fieldLabel: 'alpha', html: 'The amount of influence pheromone trail values have on the ants'},
		{xtype: 'displayfield', fieldLabel: 'beta', html: 'The amount of influence heuristic information have on the ants decision-making'},
		{xtype: 'displayfield', fieldLabel: 'm', html: 'Number of Ant Colonies'},
		{xtype: 'displayfield', fieldLabel: 'ifc', html: 'Number of initial search iterations during which no pheromone update of any kind will be done'},
		{xtype: 'displayfield', fieldLabel: 'ibu', html: 'A boolean indicating "iteration-best" pheromone update method will be used if true. Other, "best-so-far" procedure is employed.'},
		
		],
		title			: 'Erlang Process Parameter Descriptions',
		autoWidth		: true,
		frame			: true,
		iconCls			: 'info',
		style			: 'margin-top:10px',
	});
	
	var sy = new Ext.data.SimpleStore({
		fields: ['id', 'schoolyear'],
		data : [['0', '2010-2011'],['1', '2011-2012'],['2', '2012-2013'],['3', '2013-2014'],['4', '2014-2015'],['5', '2015-2016'],],
	});
	
	var sem = new Ext.data.SimpleStore({
		fields: ['id', 'sem'],
		data : [['0', '1'],['1', '2']],
	});
	
	var version = new Ext.data.SimpleStore({
		fields: ['id', 'version'],
		data : [['0', '1'],['1', '2'],['2', '3'],['3', '4'],['4', '5'],['5', '6'],['6', '7'],['7', '8'],['8', '9'],['9', '10'],],
	});

	
	var dbSchoolYear = new Ext.form.ComboBox({
		store			: sy, //direct array data
		id				: 'schoolyear',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'School Year',
		emptyText		: 'Select a School Year',
		selectOnFocus	: true,
		valueField		: 'id',
		displayField	: 'schoolyear',
		lastQuery		: '',
		anchor			: '50%',	
	});
	
	var dbSem = new Ext.form.ComboBox({
	store			: sem, //direct array data
	id				: 'semester',
	typeAhead		: true,
	allowBlank		: false,
	editable		: false,
	triggerAction	: 'all',
	fieldLabel		: 'Semester',
	emptyText		: 'Select a Semester',
	selectOnFocus	: true,
	valueField		: 'id',
	displayField	: 'sem',
	lastQuery		: '',
	anchor			: '50%',	
	});
	
	var dbVersion = new Ext.form.ComboBox({
	store			: version, //direct array data
	id				: 'version',
	typeAhead		: true,
	allowBlank		: false,
	editable		: false,
	triggerAction	: 'all',
	fieldLabel		: 'Version',
	emptyText		: 'Select a Version',
	selectOnFocus	: true,
	valueField		: 'id',
	displayField	: 'version',
	lastQuery		: '',
	anchor			: '50%',	
	});
	
	
	var dbSettings = new Ext.FormPanel({
		monitorValid	: true,
		id				: 'db-settings',
		items			: [dbSchoolYear, dbSem, dbVersion],
		title			: 'Database Settings',
		autoWidth		: true,	
		frame			: true,	
		iconCls			: 'database',	
	});

	var settingsPanel = new Ext.Panel({
		layout	: 'column',
		title	: 'General Settings',
		items	: [
			{columnWidth: .40, bodyStyle:'padding:5px 5px 5px 5px;border: 0px;', items:[erlangSettings]},
			{columnWidth: .60, bodyStyle:'padding:5px 5px 5px 5px;border: 0px;', items:[dbSettings, fieldDescriptions]}
		],
		id		: 'generate-panel',	
		tbar	: [node, cookie,],
		iconCls	: 'settings',
		buttons			: [	{
								text	: 'Save',
								formBind: true,
								
							},
							{
								text	: 'Cancel',
								handler	: 	function()
											{
												dbSettings.getForm().reset();
											},
							},
			
							{
								text	: 'Clear',
								handler	: 	function()
											{
												dbSettings.getForm().reset();
											},
							},
						],
	});	

