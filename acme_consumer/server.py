import json
import pika
from datetime import datetime
from slackclient import SlackClient

# Config
rabbitmq_host = 'docker_host'
rabbitmq_port = 5672
rabbitmq_exchange = 'unappointed_feedback'
rabbitmq_queue = 'unappointed_feedback'
rabbitmq_exchange_type = 'direct'
slack_token = "xoxp-22834931874-34259697140-35318315072-012e27fd15"
slack_name = 'The-Fit-Reminder-Squirrel'
slack_emoji_icon = ':squirrel:'

# Slack
sc = SlackClient(slack_token)

# RabbitMQ
connection = pika.BlockingConnection(
    pika.ConnectionParameters(host=rabbitmq_host, port=rabbitmq_port)
)
channel = connection.channel()
channel.exchange_declare(exchange=rabbitmq_exchange, type=rabbitmq_exchange_type)
result = channel.queue_declare(queue=rabbitmq_queue, durable=True, exclusive=True)
queue_name = result.method.queue
channel.queue_bind(exchange=rabbitmq_exchange, queue=queue_name)


def new_message_received(ch, method, properties, body):
    print(' [*] New message: %s' % body)
    slack_handle_employee, slack_handle_superior, targeted_date = parse_message(body.decode(encoding='UTF-8'))
    formatted_date = targeted_date.strftime('%d.%m.%Y')
    message = 'Hi! Please schedule a feedback-appointment with %s. The targeted date is %s' % (slack_handle_employee, formatted_date)
    write_message_to_channel(slack_handle_superior, message)


def parse_message(message):
    """
    :param message: JSON({
        "feedback_id": 142,
        "slackHandle_superior": "@vanessa_wrede",
        "slackHandle_employee": "@julian.nuss",
        "targetDate":{
            "date":          "2016-05-29 08:34:24.000000",
            "timezone_type": 3,
            "timezone":      "UTC"
        }
    })

    :return: string, datetime
    """

    parsed_json = json.loads(message)
    slack_handle_employee = parsed_json['slackHandle_employee']
    slack_handle_superior = parsed_json['slackHandle_superior']
    targeted_date = datetime.strptime("2013-1-25", '%Y-%m-%d')

    return slack_handle_employee, slack_handle_superior, targeted_date


def test_slack_api():
    api_test_result = sc.api_call("api.test")
    if 'error' in api_test_result:
        error_message = api_test_result['error']
    else:
        error_message = ''
    return api_test_result['ok'], error_message


def main():
    status, error = test_slack_api()
    if status:
        print(' [*] Waiting for messages. To exit press CTRL+C')
        channel.basic_consume(new_message_received, queue=queue_name, no_ack=True)
        channel.start_consuming()
    else:
        print(' [X] ERROR: ' + error)


def write_message_to_channel(to, message):
    print(
        sc.api_call(
            "chat.postMessage",
            channel=to,
            text=message.encode(encoding='UTF-8'),
            username=slack_name,
            icon_emoji=slack_emoji_icon,
            parse='none'
        )
    )


if __name__ == '__main__':
    main()
