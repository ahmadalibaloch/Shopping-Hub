<?php
class Message extends Model
{
	static $table = 'messages';
	static $cols = 'id, name, topic, email, message';
}