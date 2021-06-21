DELIMITER $$;
create trigger update_storage_on_file_delete AFTER delete
on files
for each row
BEGIN
	update storage set used=(storage.used-OLD.FILE_SIZE) where user = OLD.OWNER;
END
