import React from "react";
import "./user.style.scss";
import Axios from "axios";
import { connect } from "react-redux";

class User extends React.Component {
  componentDidMount() {
    Axios.get(`/api/forms/${this.props.userId}`)
      .then(res => console.log(res.data))
      .catch(err => console.log(err));
  }

  render() {
    return (
      <div className="user">
        <h1>This is user page</h1>
        {/* {console.log(this.props.userId)} */}
      </div>
    );
  }
}

const mapStateToProps = state => ({
  userId: state.user.userId
});

export default connect(mapStateToProps, null)(User);
