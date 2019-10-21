<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountCount;
use App\Baddict;
use App\Contact;
use App\Count;
use App\Err;
use App\HSN;
use Carbon\Carbon;
use danog\MadelineProto\contacts;
use danog\MadelineProto\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelegramController extends Controller
{
	public function init()
	{
		if (!file_exists('madeline.php'))
		{
			copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
		}

		include 'madeline.php';

		$MadelineProto = new \danog\MadelineProto\API('session.madeline');
		$MadelineProto->start();

		$Chat = $MadelineProto->get_pwr_chat('https://t.me/bitcoinaddictclub');
		$MadelineProto->channels->joinChannel(['channel' => 'https://t.me/bitcoinaddictclub']);
//
//		$users = $Chat['participants'];
//
////		dd($Chat);
//
//		foreach ($users as $user)
//		{
//			$user = $user['user'];
//
//			if (array_key_exists('first_name', $user))
//			{
//				$user['user_id'] = $user['id'];
//				if (array_key_exists('status', $user))
//				{
//					$time = new Carbon();
//					if (array_key_exists('was_online', $user['status']))
//					{
//						$user['last_online'] = $time::createFromTimestamp($user['status']['was_online'])->toDateString();
//					}
//				}
//
//				Baddict::create($user);
//			}
//		}

	}

	public function changeSession()
	{
		$this->deleteS();

		$count = AccountCount::first();

		$account = Account::find($count->value)->value;

		$set = count(Account::all()->toArray());

		if ($count->value == $set)
		{
			$count->value = 1;
		} else
		{
			$count->value += 1;
		}

		$count->save();

		$this->session($account);
	}

	public function test()
	{
		$this->changeSession();
	}

	public function session($name)
	{
		$path = $name;
		Storage::disk('controller')->copy($path . '/session.madeline', 'session.madeline');
		Storage::disk('controller')->copy($path . '/session.madeline.lock', 'session.madeline.lock');

	}

	public function deleteS()
	{
		Storage::disk('controller')->delete('session.madeline');
		Storage::disk('controller')->delete('session.madeline.lock');
	}

	public function addUser()
	{
		$this->changeSession();

		$no = 10;

		$count = Count::first();

		$start = $count->toArray()['value'];

		$end = $start + $no;

		$contacts = HSN::all();

		$users = [];

		for ($x = $start; $x < $end; $x ++)
		{
			array_push($users, $contacts[$x]->user_id);
//			array_push($users, ['_' => 'inputUser', 'user_id' => $contacts[$x]->user_id, 'access_hash' => $contacts[$x]->access_hash]);
		}


		$count->value += $no;

		$count->save();

//		dd($users);

		if (!file_exists('madeline.php'))
		{
			copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
		}

		include 'madeline.php';

		$MadelineProto = new \danog\MadelineProto\API('session.madeline');
		$MadelineProto->start();
//
//		$MadelineProto->messages->sendMessage(['peer' => '@danogentili', 'message' => "Hi!\nThanks for creating MadelineProto! <3"]);
//		$MadelineProto->channels->joinChannel(['channel' => '@MadelineProto']);

//		try
//		{
			$Updates = $MadelineProto->channels->inviteToChannel(['channel' => 'https://t.me/hsn_telegram', 'users' => $users,]);
//		} catch (Exception $e)
//		{
//			Err::create(['value' => $start]);

//			return $e;
//		}
//
		dd($Updates);
	}

	public function checkDup()
	{
//		$contacts = Baddict::all()->toArray();
//
//		foreach ($contacts as $contact)
//		{
//			$dup = HSN::where('access_hash', $contact['access_hash'])->first();
//
//			if (!is_null($dup))
//			{
////				dd($dup);
////				Contact::find($contact['id'])->update(['dup' => 1]);
//			}else{
////				dd($contact);
//				Contact::create($contact);
//			}
//		}

		$contacts = Contact::orderBy('last_online', 'asc')->get()->toArray();

		foreach ($contacts as $contact)
		{
			if (!is_null($contact['last_online']))
			{
				HSN::create($contact);
			}
		}

	}
}
