import React from "react";

class ChangeComment extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      changeComment: false,
      inputValue: props.name
    };
  }

  handle = () => {
    const { id, rowId, criteriaId, criteriaName, change } = this.props;
    change(id, rowId, criteriaId, criteriaName, this.state.inputValue);
    this.setState({ changeComment: !this.state.changeComment });
  };

  render() {
    return (
      <td>
        {this.state.changeComment ? (
          <React.Fragment>
            <input
              type="text"
              placeholder={this.state.inputValue}
              onChange={value =>
                this.setState({ inputValue: value.target.value })
              }
            />
            <button onClick={this.handle}>Save</button>
          </React.Fragment>
        ) : (
          <React.Fragment>
            {this.state.inputValue}
            <button
              onClick={() =>
                this.setState({ changeComment: !this.state.changeComment })
              }
            >
              Change
            </button>
          </React.Fragment>
        )}
      </td>
    );
  }
}

export default ChangeComment;
