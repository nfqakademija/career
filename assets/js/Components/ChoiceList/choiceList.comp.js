import React from "react";
import { connect } from "react-redux";
import {
  setAnswers,
  updateChoiceAnswerUserSide,
  isActionCalled
} from "../../Actions/action";

import { checkForAnswerId } from "../../helpers/helpers";

class ChoiceList extends React.Component {
  onSelect = event => {
    const selectedIndex = event.target.options.selectedIndex;
    const choiceId = event.target.options[selectedIndex].getAttribute(
      "data-value"
    );

    let answerId = checkForAnswerId(
      this.props.choiceList,
      this.props.criteriaId
    );

    this.props.onSetAnswers(this.props.criteriaId, choiceId, answerId);
    this.props.onUpdateChoiceAnswer(this.props.criteriaId, choiceId);
    this.props.onSetChangedValues(true);
  };

  render() {
    const { choices } = this.props;
    let answer = "Not answered";
    for (let i = 0; i < this.props.choiceList.length; i++) {
      for (let j = 0; j < choices.length; j++) {
        if (this.props.choiceList[i].choiceId === choices[j].id) {
          answer = choices[j].title;
        }
      }
    }

    if (this.props.managerPage) {
      return <div>{answer}</div>;
    }

    return (
      <select
        className="choiceListSelect"
        defaultValue={answer}
        onChange={this.onSelect}
      >
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
  choiceList: state.answerListUserSide.choiceList,
  managerPage: state.managerPage.selected
});

const mapDispatchToProps = dispatch => ({
  onSetAnswers: (criteriaId, choiceId, answerId) =>
    dispatch(setAnswers(criteriaId, choiceId, answerId)),
  onUpdateChoiceAnswer: (criteriaId, choiceId) =>
    dispatch(updateChoiceAnswerUserSide(criteriaId, choiceId)),
  onSetChangedValues: bollean => dispatch(isActionCalled(bollean))
});

export default connect(mapStateToProps, mapDispatchToProps)(ChoiceList);
