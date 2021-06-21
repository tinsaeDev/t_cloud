// should not be executed yet
DELIMITER $$;
create trigger update_storage_on_file_insert AFTER insert
on files
for each row
BEGIN
	update storage set used=(storage.used+NEW.FILE_SIZE) where user = NEW.OWNER;
END
