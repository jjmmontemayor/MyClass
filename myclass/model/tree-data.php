<?php

echo "[
   { id: 'courses-grid',	text: 'Courses', 			leaf: true },
   { id: 'locations-grid', 	text: 'Locations', 			leaf: true },
   { id: 'timeslots-grid', 	text: 'Timeslots', 			leaf: true },
   { id: 'faculties-grid', 	text: 'Faculties', 			leaf: true },
   { id: 'faculty-events', 	text: 'Faculty Events', 	leaf: true },
   { id: '6', 
	text: 'Properties', expanded: true,
    children: [	{id: 'colleges-grid',		text: 'Colleges',		leaf: true, },
				{id: 'departments-grid',	text: 'Departments',	leaf: true},
				{id: 'subjects-grid',		text: 'Subjects',		leaf: true},
				{id: 'types-grid',			text: 'Types',			leaf: true},
				{id: 'items-grid',			text: 'Items',			leaf: true},
				{id: 'scopes-grid',			text: 'Scope',			leaf: true},
				{id: 'days-grid',			text: 'Days',			leaf: true},	
				{id: 'time-grid',			text: 'Time',			leaf: true},
	 ]
   }
]";
?>