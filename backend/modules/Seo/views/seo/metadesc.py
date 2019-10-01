# -*- coding: UTF8 -*-
import csv
import os
from sumy.parsers.html import HtmlParser
from sumy.parsers.plaintext import PlaintextParser
from sumy.nlp.tokenizers import Tokenizer
from sumy.summarizers.lsa import LsaSummarizer as Lsa
from sumy.summarizers.luhn import LuhnSummarizer as Luhn
from sumy.summarizers.text_rank import TextRankSummarizer as TxtRank
from sumy.summarizers.lex_rank import LexRankSummarizer as LexRank
from sumy.summarizers.sum_basic import SumBasicSummarizer as SumBasic
from sumy.summarizers.kl import KLSummarizer as KL
from sumy.summarizers.edmundson import EdmundsonSummarizer as Edmundson
from sumy.nlp.stemmers import Stemmer
from sumy.utils import get_stop_words
import sys
import json


import requests




def file_to_string(file):
    infile = file
    f = open(infile, 'r', )
    theText = f.read()
    f.close()
    return theText



text = sys.argv[1]


r = requests.get('http://api.modulus.up/v1/article/view?id='+str(text))
responseObj=json.loads(r.text)

ptext=responseObj['body']
text=json.dumps(ptext)
#text="BUDAPEST WINE TASTING & PLAY </p><p>Taste & Play on our Budapest River Cruise </p><p>Have you ever been to Hungary while having international casino based party games where you can learn the tricks of wine tasting while floating on the Danube River and enjoying live music, have you? We highly doubt it, since our matchless Taste and Play program has just been launched and now is ready for adventurous pioneers to take a chance on the good luck and the sensitive sensory organs. It is recommended not just for professional wine tasters, but for beginners too. So if you are interested in quality wines but you have gained a little experience, the time has arrived to boost your knowledge. </p><p>wine tasting cruise budapest </p><p>What to expect? Well, valuable information on Hungary’s wine regions and exciting description of wines. Hence, at the next family gathering or company event, you can act as a wine expert. Or if you regard yourself as a professional taster, come and take a risk, test your knowledge meanwhile having a good time with other people of the same interest. </p><p>So what is it exactly? Basically, this is a casino themed wine tasting event, where you can enjoy the excitement of a casino game while experimenting the way of proper wine tasting. We recommend it for team building, stag party, even for family occasions if everyone is over 18. </p><p>How do we play our Wine Tasting Game? </p><p>Upon arrival at the entrance kind hostesses await you and show your table. </p><p>At the beginning of the game, we give you all the chips you have to organize during the game and you get a new personality since we use name cards for remembering each other's names. Don't think we learn each other's real name, but you can hide behind the face of a famous character such as Pinocchio or Queen Elisabeth. These chips are distributed for everyone equally. As a matter of fact, the chips’ value is, basically, the price of the wine casino; therefore, you can use your money twice in the evening. By the way, if you are afraid to apply alone, there is an opportunity too to play in "

#text="Hello my name is Wattson. Welcome. to jack ass. "

#text=file_to_string('cikk.txt')

#print(text2)


def __init__():
    LANGUAGE = "english"
    SENTENCES_COUNT = 1


    stemmer = Stemmer(LANGUAGE)
    budapestrivercruise.com
    lsaSummarizer = Lsa(stemmer)
    lsaSummarizer.stop_words = get_stop_words(LANGUAGE)
    luhnSummarizer = Luhn(stemmer)
    luhnSummarizer.stop_words = get_stop_words(LANGUAGE)
    # edmundsonSummarizer.bonus_words = get_bonus_words

    lexrankSummarizer = LexRank(stemmer)
    lexrankSummarizer.stop_words = get_stop_words(LANGUAGE)

    textrankSummarizer = TxtRank(stemmer)
    textrankSummarizer.stop_words = get_stop_words(LANGUAGE)

    sumbasicSummarizer = SumBasic(stemmer)
    sumbasicSummarizer.stop_words = get_stop_words(LANGUAGE)


    klSummarizer = KL(stemmer)
    klSummarizer.stop_words = get_stop_words(LANGUAGE)

    parser = HtmlParser.from_string(text, 0, Tokenizer(LANGUAGE))

    allvariations = []

    for sentence in lsaSummarizer(parser.document, SENTENCES_COUNT):
       # print("Summarizing text via LSA: ")
        print((str(sentence)))


        allvariations.append(sentence)
    for sentence in luhnSummarizer(parser.document, SENTENCES_COUNT):
        #print("Summarizing text via Luhn: ")
        print(str(sentence))
        allvariations.append(sentence)
    for sentence in lexrankSummarizer(parser.document, SENTENCES_COUNT):
        #print("Summarizing text via Lexrank: ")
        print(str(sentence))
        allvariations.append(sentence)
    for sentence in textrankSummarizer(parser.document, SENTENCES_COUNT):
        #print("Summarizing text via Textrank: ")
        print(str(sentence))
        allvariations.append(sentence)
    for sentence in sumbasicSummarizer(parser.document, SENTENCES_COUNT):
        #print("Summarizing text via Sumbasic: ")
        print(str(sentence))
        allvariations.append(sentence)
    for sentence in klSummarizer(parser.document, SENTENCES_COUNT):
        #print("Summarizing text via klSum: ")
        print(str(sentence))
        allvariations.append(sentence)
        return allvariations

__init__()
