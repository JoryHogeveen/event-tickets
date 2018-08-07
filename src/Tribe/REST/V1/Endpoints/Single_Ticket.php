<?php

class Tribe__Tickets__REST__V1__Endpoints__Single_Ticket
	extends Tribe__Tickets__REST__V1__Endpoints__Base
	implements Tribe__REST__Endpoints__READ_Endpoint_Interface,
	Tribe__Documentation__Swagger__Provider_Interface {

	/**
	 * {@inheritdoc}
	 */
	public function get_documentation() {
		// @todo implement this for ticket https://central.tri.be/issues/108024
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get( WP_REST_Request $request ) {
		$ticket_id = $request['id'];

		$ticket_data = $this->get_readable_ticket_data( $ticket_id );

		if ( $ticket_data instanceof WP_Error ) {
			return $ticket_data;
		}

		/**
		 * Filters the data that will be returned for a single ticket request.
		 *
		 * @since TBD
		 *
		 * @param array           $data    The ticket data.
		 * @param WP_REST_Request $request The original request.
		 */
		$data = apply_filters( 'tribe_rest_single_ticket_data', $ticket_data, $request );

		return $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function READ_args() {
		return array(
			'id' => array(
				'type'              => 'integer',
				'description'       => __( 'The ticket post ID', 'event-tickets' ),
				'required'          => true,
				/**
				 * Here we check for a positive int, not a ticket ID to properly
				 * return 404 for missing post in place of 400.
				 */
				'validate_callback' => array( $this->validator, 'is_positive_int' ),
			),
		);
	}
}