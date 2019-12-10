import React from "react";
// import { setSelectedProfile } from "../../Actions/action";
// import Axios from 'axios';
// import { connect } from "react-redux";

class ProfileButtons extends React.Component {
  render() {
    const { id, name, handle } = this.props;
    return (
      <div>
        <button onClick={() => handle(id)}>
          {name}
        </button>
      </div>
    );
  }
}

export default ProfileButtons;
