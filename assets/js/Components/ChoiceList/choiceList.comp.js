import React from "react";
import { connect } from "react-redux";
import { setAnswers } from "../../Actions/action";

class ChoiceList extends React.Component {
  onSelect = event => {
    const selectedIndex = event.target.options.selectedIndex;
    const choiceId = event.target.options[selectedIndex].getAttribute(
      "data-value"
    );
    this.props.onSetAnswers(this.props.criteriaId, choiceId);
  };

  render() {
    const { choices } = this.props;
    let answer = "Not answered";
    for(let i = 0; i < this.props.choiceList.length; i++){
      for(let j = 0; j < choices.length; j++){
        if(this.props.choiceList[i].choiceId === choices[j].id){
          answer = choices[j].title;
        }
      }
    }

    return (
      <select defaultValue={answer} onChange={this.onSelect}>
        {answer === "Not answered" ? (
          <option value="Not answered">--Not answered--</option>
        ) : null}
        {choices.map(choice => (
          <option key={choice.id} value={choice.title} data-value={choice.id}>
            {choice.title}
          </option>
        ))}
      </select>
    );
  }
}

const mapStateToProps = state => ({
  answers: state.trackUserChanges.choiceAnswers,
  choiceList: state.user.choiceList
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId) =>
    dispatch(setAnswers(criteriaId, choiceId))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceList);
