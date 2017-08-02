<?php
/**
 * Created by PhpStorm.
 * User: Aiste
 * Date: 2017-07-20
 * Time: 15:04
 */
require_once 'config.php';

class ClientAPI
{

    /**
     * GET
     * @param $endpoint
     * @param string $id
     * @return mixed
     */
    protected static function get($endpoint, $id = '')
    {
        $service_url = URL . "$endpoint/$id/apikey/" . APIKEY;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->error)) {
            die('error occured: ' . $decoded->response->error);
        }
        return $decoded->response;
    }

    /**
     * POST
     * @param $endpoint
     * @param $data
     * @return mixed
     */
    protected static function post($endpoint, $data)
    {
        $service_url = URL . "$endpoint";
        $curl = curl_init($service_url);
        $data['apikey'] = APIKEY;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->error)) {
            die('error occured: ' . $decoded->response->error);
        }
        return $decoded->response;
    }

    /**
     * PUT
     * @param $endpoint
     * @param $data
     * @param $id
     * @return mixed
     */
    protected static function put($endpoint, $data, $id)
    {
        $service_url = URL . "$endpoint/$id/apikey/" . APIKEY;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->error)) {
            die('error occured: ' . $decoded->response->error);
        }
        return $decoded->response;
    }

    /**
     * DELETE
     * @param $endpoint
     * @param $id
     * @param array $data
     * @return mixed
     */
    protected static function delete($endpoint, $id, $data = array())
    {
        $service_url = URL . "$endpoint/$id/apikey/" . APIKEY;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->error)) {
            die('error occured: ' . $decoded->response->error);
        }
        return $decoded->response;

    }

    /**
     * Get user by id.
     * @param $id
     * @return mixed
     */
    public static function getUser(int $id)
    {
        return self::get('users', $id);
    }

    /**
     * Get all users.
     * @return mixed
     */
    public static function getUsers()
    {
        return self::get('users');
    }

    /**
     * Add new user.
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function addUser($name, $email, $password)
    {
        return self::post('users', array('name' => $name, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)));
    }

    /**
     * Update existing user.
     * @param $id
     * @param $name
     * @param $email
     * @param $password
     * @return mixed
     */
    public static function updateUser(int $id, $name, $email, $password)
    {
        return self::put('users', array('name' => $name, 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)), $id);
    }

    /**
     * Delete user.
     * @param $id
     * @return mixed
     */
    public static function deleteUser(int $id)
    {
        return self::delete('users', $id);
    }

    /**
     * Get company by id.
     * @param $id
     * @return mixed
     */
    public static function getCompany(int $id)
    {
        return self::get('companies', $id);
    }

    /**
     * Get all companies.
     * @return mixed
     */
    public static function getCompanies()
    {
        return self::get('companies');
    }

    /**
     * Add new company.
     * @param $name
     * @param $address
     * @param $city
     * @param $country
     * @param $tel
     * @param $email
     * @param $reg_number
     * @param null $postcode
     * @param null $vat_number
     * @return mixed
     */
    public static function addCompany($name, $address, $city, $country, $tel, $email, $reg_number, $postcode = NULL, $vat_number = NULL)
    {
        return self::post('companies', array('name' => $name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email, 'reg_number' => $reg_number, 'vat_number' => $vat_number));
    }

    /**
     * Update existing company.
     * @param $id
     * @param $name
     * @param $address
     * @param $city
     * @param $country
     * @param $tel
     * @param $email
     * @param $reg_number
     * @param null|string $postcode
     * @param null|string $vat_number
     * @return mixed
     */
    public static function updateCompany(int $id, $name, $address, $city, $country, $tel, $email, $reg_number, $postcode = '', $vat_number = '')
    {
        return self::put('companies', array('name' => $name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email, 'reg_number' => $reg_number, 'vat_number' => $vat_number), $id);
    }

    /**
     * Delete company.
     * @param $id
     * @return mixed
     */
    public static function deleteCompany(int $id)
    {
        return self::delete('companies', $id);
    }

    /**
     * Get hotel by id.
     * @param $id
     * @return mixed
     */
    public static function getHotel(int $id)
    {
        return self::get('hotels', $id);
    }

    /**
     * Get all hotels.
     * @return mixed
     */
    public static function getHotels()
    {
        return self::get('hotels');
    }

    /**
     * Add new hotel.
     * @param $name
     * @param $address
     * @param $city
     * @param $country
     * @param $tel
     * @param $email
     * @param null $company_id
     * @param null $postcode
     * @return mixed
     */
    public static function addHotel($name, $address, $city, $country, $tel, $email, $company_id = NULL, $postcode = NULL)
    {
        return self::post('hotels', array('name' => $name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email, 'company_id' => $company_id));
    }

    /**
     * Update existing hotel.
     * @param $id
     * @param $name
     * @param $address
     * @param $city
     * @param $country
     * @param $tel
     * @param $email
     * @param string $company_id
     * @param null|string $postcode
     * @return mixed
     */
    public static function updateHotel(int $id, $name, $address, $city, $country, $tel, $email, $company_id = '', $postcode = '')
    {
        return self::put('hotels', array('name' => $name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email, 'company_id' => $company_id), $id);
    }

    /**
     * Delete hotel.
     * @param $id
     * @return mixed
     */
    public static function deleteHotel(int $id)
    {
        return self::delete('hotels', $id);
    }

    /**
     * Get room_type by id.
     * @param $id
     * @return mixed
     */
    public static function getRoomType(int $id)
    {
        return self::get('room_types', $id);
    }

    /**
     * Get all room_types.
     * @return mixed
     */
    public static function getRoomTypes()
    {
        return self::get('room_types');
    }

    /**
     * Add new room_type.
     * @param $name
     * @param $hotel_id
     * @param int $max_capacity
     * @param float $price
     * @return mixed
     */
    public static function addRoomType($name, $hotel_id, $max_capacity = 1, $price = 0.000)
    {
        return self::post('room_types', array('name' => $name, 'max_capacity' => $max_capacity, 'price' => $price, 'hotel_id' => $hotel_id));
    }

    /**
     * Update existing room_type.
     * @param $id
     * @param $name
     * @param $hotel_id
     * @param int $max_capacity
     * @param float $price
     * @return mixed
     */
    public static function updateRoomType(int $id, $name, $hotel_id, $max_capacity = 1, $price = 0.000)
    {
        return self::put('room_types', array('name' => $name, 'max_capacity' => $max_capacity, 'price' => $price, 'hotel_id' => $hotel_id), $id);
    }

    /**
     * Delete room_type.
     * @param $id
     * @return mixed
     */
    public static function deleteRoomType(int $id)
    {
        return self::delete('room_types', $id);
    }

    /**
     * Get room by id.
     * @param $id
     * @return mixed
     */
    public static function getRoom(int $id)
    {
        return self::get('rooms', $id);
    }

    /**
     * Get all rooms.
     * @return mixed
     */
    public static function getRooms()
    {
        return self::get('rooms');
    }

    /**
     * Add new room.
     * @param $number
     * @param $room_type_id
     * @param $name
     * @param null $status
     * @param int $smoke
     * @param null $additional_price
     * @return mixed
     */
    public static function addRoom($number, $room_type_id, $name = NULL, $status = NULL, $smoke = 0, $additional_price = NULL)
    {
        return self::post('rooms', array('number' => $number, 'name' => $name, 'status' => $status, 'smoke' => $smoke, 'additional_price' => $additional_price, 'room_type_id' => $room_type_id));
    }

    /**
     * Update existing room.
     * @param $id
     * @param $number
     * @param $room_type_id
     * @param $name
     * @param null $status
     * @param int $smoke
     * @param null $additional_price
     * @return mixed
     */
    public static function updateRoom(int $id, $number, $room_type_id, $name = '', $status = '', $smoke = 0, $additional_price = '')
    {
        return self::put('rooms', array('number' => $number, 'name' => $name, 'status' => $status, 'smoke' => $smoke, 'additional_price' => $additional_price, 'room_type_id' => $room_type_id), $id);
    }

    /**
     * Delete room.
     * @param $id
     * @return mixed
     */
    public static function deleteRoom(int $id)
    {
        return self::delete('rooms', $id);
    }

    /**
     * Get reservation by id.
     * @param $id
     * @return mixed
     */
    public static function getReservation(int $id)
    {
        return self::get('reservations', $id);
    }

    /**
     * Get all reservations.
     * @return mixed
     */
    public static function getReservations()
    {
        return self::get('reservations');
    }

    /**
     * Add new reservation.
     * @param $date_in
     * @param $date_out
     * @param $guest_id
     * @param int $adults
     * @param null $kids
     * @param null $pets
     * @param null $comment
     * @param null $made_by
     * @return mixed
     */
    public static function addReservation($date_in, $date_out, $guest_id, $adults = 1, $kids = NULL, $pets = NULL, $comment = NULL, $made_by = NULL)
    {
        return self::post('reservations', array('date_in' => $date_in, 'date_out' => $date_out, 'adults' => $adults, 'kids' => $kids, 'pets' => $pets, 'comment' => $comment, 'made_by' => $made_by, 'guest_id' => $guest_id));
    }

    /**
     * Update existing reservation.
     * @param $id
     * @param $date_in
     * @param $date_out
     * @param $guest_id
     * @param int $adults
     * @param string $kids
     * @param string $pets
     * @param string $comment
     * @param string $made_by
     * @return mixed
     */
    public static function updateReservation(int $id, $date_in, $date_out, $guest_id, $adults = 1, $kids = '', $pets = '', $comment = '', $made_by = '')
    {
        return self::put('reservations', array('date_in' => $date_in, 'date_out' => $date_out, 'adults' => $adults, 'kids' => $kids, 'pets' => $pets, 'comment' => $comment, 'made_by' => $made_by, 'guest_id' => $guest_id), $id);
    }

    /**
     * Delete reservation.
     * @param $id
     * @return mixed
     */
    public static function deleteReservation(int $id)
    {
        return self::delete('reservations', $id);
    }

    /**
     * Get reserved_room by id.
     * @param $id
     * @return mixed
     */
    public static function getReservedRoom(int $id)
    {
        return self::get('reserved_rooms', $id);
    }

    /**
     * Get all reserved_rooms.
     * @return mixed
     */
    public static function getReservedRooms()
    {
        return self::get('reserved_rooms');
    }

    /**
     * Add new reserved_room.
     * @param $room_type_id
     * @param $reservation_id
     * @param $status
     * @param int $number_of_rooms
     * @return mixed
     */
    public static function addReservedRoom($room_type_id, $reservation_id, $status, $number_of_rooms = 1)
    {
        return self::post('reserved_rooms', array('number_of_rooms' => $number_of_rooms, 'room_type_id' => $room_type_id, 'reservation_id' => $reservation_id, 'status' => $status));
    }

    /**
     * Update existing reserved_room.
     * @param $id
     * @param $room_type_id
     * @param $reservation_id
     * @param $status
     * @param int $number_of_rooms
     * @return mixed
     */
    public static function updateReservedRoom(int $id, $room_type_id, $reservation_id, $status, $number_of_rooms = 1)
    {
        return self::put('reserved_rooms', array('number_of_rooms' => $number_of_rooms, 'room_type_id' => $room_type_id, 'reservation_id' => $reservation_id, 'status' => $status), $id);
    }

    /**
     * Delete reserved_room.
     * @param $id
     * @return mixed
     */
    public static function deleteReservedRoom(int $id)
    {
        return self::delete('reserved_rooms', $id);
    }

    /**
     * Get occupied_room by id.
     * @param $id
     * @return mixed
     */
    public static function getOccupiedRoom(int $id)
    {
        return self::get('occupied_rooms', $id);
    }

    /**
     * Get all occupied_rooms.
     * @return mixed
     */
    public static function getOccupiedRooms()
    {
        return self::get('occupied_rooms');
    }

    /**
     * Add new occupied_room.
     * @param $room_id
     * @param $reservation_id
     * @param null $check_in
     * @param null $check_out
     * @return mixed
     */
    public static function addOccupiedRoom($room_id, $reservation_id, $check_in = NULL, $check_out = NULL)
    {
        return self::post('occupied_rooms', array('check_in' => $check_in, 'check_out' => $check_out, 'room_id' => $room_id, 'reservation_id' => $reservation_id));
    }

    /**
     * Update existing occupied_room.
     * @param $id
     * @param $room_id
     * @param $reservation_id
     * @param null $check_in
     * @param null $check_out
     * @return mixed
     */
    public static function updateOccupiedRoom(int $id, $room_id, $reservation_id, $check_in = '', $check_out = '')
    {
        return self::put('occupied_rooms', array('check_in' => $check_in, 'check_out' => $check_out, 'room_id' => $room_id, 'reservation_id' => $reservation_id), $id);
    }

    /**
     * Delete occupied_room.
     * @param $id
     * @return mixed
     */
    public static function deleteOccupiedRoom(int $id)
    {
        return self::delete('occupied_rooms', $id);
    }

    /**
     * Get guest by id.
     * @param $id
     * @return mixed
     */
    public static function getGuest(int $id)
    {
        return self::get('guests', $id);
    }

    /**
     * Get all guests.
     * @return mixed
     */
    public static function getGuests()
    {
        return self::get('guests');
    }

    /**
     * Add new guest.
     * @param $first_name
     * @param $last_name
     * @param $address
     * @param $city
     * @param $country
     * @param null $postcode
     * @param null $tel
     * @param $email
     * @return mixed
     */
    public static function addGuest($first_name, $last_name, $address, $city, $country, $postcode = NULL, $tel = NULL, $email = NULL)
    {
        return self::post('guests', array('first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email));
    }

    /**
     * Update existing guest.
     * @param $id
     * @param $first_name
     * @param $last_name
     * @param $address
     * @param $city
     * @param $country
     * @param null|string $postcode
     * @param null|string $tel
     * @param string $email
     * @return mixed
     */
    public static function updateGuest(int $id, $first_name, $last_name, $address, $city, $country, $postcode = '', $tel = '', $email = '')
    {
        return self::put('guests', array('first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'city' => $city, 'postcode' => $postcode, 'country' => $country, 'tel' => $tel, 'email' => $email), $id);
    }

    /**
     * Delete guest.
     * @param $id
     * @return mixed
     */
    public static function deleteGuest(int $id)
    {
        return self::delete('guests', $id);
    }
}