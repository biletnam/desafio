select d.dept_name, concat(e.first_name,' ',e.last_name) as full_name, d2e.to_date, d2e.from_date, (TO_DAYS(d2e.to_date) - TO_DAYS(d2e.from_date)) as diff 
from dept_emp as d2e, departments as d, employees as e where d.dept_no = d2e.dept_no 
and e.emp_no = d2e.emp_no order by diff desc;