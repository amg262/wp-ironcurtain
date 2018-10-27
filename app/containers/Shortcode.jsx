import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Shortcode extends Component {
  render() {
    return (
      <div>
        <h1>BOM Tracker Frontend</h1>
        <p>Title: {this.props.wpObject.title}</p>
      </div>
    );
  }
}

Shortcode.propTypes = {
  wpObject: PropTypes.object
};