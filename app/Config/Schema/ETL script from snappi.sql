USE wms;

SELECT * FROM snappi.users u where  primary_group_id IN ('role-----0123-4567-89ab-------editor', 'role-----0123-4567-89ab------manager');

INSERT INTO editors (user_id, username, password, role, work_week, workday_hours, created, modified  )
SELECT u.id, u.username, u.password, if(u.primary_group_id='role-----0123-4567-89ab------manager', 'manager', 'operator'),  '1111100', 6.0, now(), now()
FROM snappi.users u where  primary_group_id IN ('role-----0123-4567-89ab-------editor', 'role-----0123-4567-89ab------manager');

SELECT * FROM editors e;


INSERT INTO tasks (uuid, name, description, target_work_rate, created)
SELECT t.id, t.name, t.description, 500, now() FROM snappi_workorders.tasks t;

SELECT * FROM tasks t;

INSERT INTO workorders (uuid, client_id, source_id, source_model, manager_id, name, description, harvest, status, assets_workorder_count, active, created, modified)
SELECT w.id, w.client_id, w.source_id, w.source_model, e.id as manager_id, w.name, w.description, w.harvest, w.work_status, w.assets_workorder_count, w.active, w.created, w.modified
FROM snappi_workorders.workorders w
left JOIN editors e ON e.user_id = w.manager_id;

SELECT * FROM workorders w;


INSERT INTO tasks_workorders (uuid, workorder_id, task_id, task_sort, operator_id, status, assets_task_count, active, created, modified)
SELECT tw.id, w.id as workorder_id, t.id as task_id, tw.task_sort, e.id as operator_id, tw.status, tw.assets_task_count, tw.active, tw.created, tw.modified
FROM snappi_workorders.tasks_workorders tw
JOIN workorders w on w.uuid = tw.workorder_id
JOIN tasks t on t.uuid=tw.task_id
left JOIN editors e ON e.user_id = tw.operator_id;

SELECT * FROM tasks_workorders t;


INSERT INTO assets_workorders (workorder_id, asset_id, created)
SELECT w.id as workorder_id, aw.asset_id, aw.created
FROM snappi_workorders.assets_workorders aw
JOIN workorders w on w.uuid = aw.workorder_id;

SELECT * FROM assets_workorders a;


INSERT INTO assets_tasks (tasks_workorder_id, asset_id, created, edit_count)
SELECT tw.id as tasks_workorder_id, at.asset_id,  at.created, count(ue.id) as edit_count
FROM snappi_workorders.assets_tasks at
JOIN tasks_workorders tw on tw.uuid = at.tasks_workorder_id
LEFT JOIN snappi.user_edits ue ON ue.asset_id = at.asset_id AND owner_id in (select e.user_id from editors e)
GROUP BY at.id, at.asset_id;

SELECT * FROM assets_tasks a;


INSERT INTO skills (editor_id, task_id, rate_7_day, created, modified)
SELECT id, 1,  500, now(), now() FROM editors;

SELECT * FROM skills s;