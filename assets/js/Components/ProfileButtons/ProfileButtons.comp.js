import React from "react";
import { setSelectedProfile } from "../../Actions/action";

import { connect } from "react-redux";

class ProfileButtons extends React.Component {
  render() {
    const { id, name } = this.props;
    return (
      <div>
        <button onClick={() => this.props.onSetSelectedProfile(id)}>
          {name}
        </button>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  selectedProfile: state.selectedProfile.id
});
const mapDispatchToProps = dispatch => ({
  onSetSelectedProfile: profile => dispatch(setSelectedProfile(profile))
});

export default connect(mapStateToProps, mapDispatchToProps)(ProfileButtons);
